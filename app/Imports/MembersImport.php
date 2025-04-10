<?php

namespace App\Imports;

use App\Models\Member;
use App\Models\Chapter;
use App\Models\District;
use App\Models\MembershipType;
use App\Models\ParentsMultipleDistrict;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;

class MembersImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    public function collection(Collection $rows)
    {
        $batchData = [];

        foreach ($rows as $row) {
            $firstName = isset($row['first_name']) ? trim($row['first_name']) : null;
            if (empty($firstName)) {
                Log::error("Missing first_name for row: " . json_encode($row));
                continue;
            }

            // Fetch or create related models
            $parentMultipleDistrict = ParentsMultipleDistrict::firstOrCreate([
                'name' => trim($row['parent_multiple_district'] ?? '')
            ]);
            $parentDistrict = District::firstOrCreate([
                'name' => trim($row['parent_district'] ?? '')
            ]);
            $accountName = Chapter::firstOrCreate([
                'chapter_name' => trim($row['account_name'] ?? '')
            ]);
            $membershipFullType = MembershipType::firstOrCreate([
                'name' => trim($row['membership_full_type'] ?? '')
            ]);

            $dob = $this->formatDate($row['dob'] ?? null);
            $anniversaryDate = $this->formatDate($row['anniversary_date'] ?? null);

            $batchData[] = [
                'parent_multiple_district' => $parentMultipleDistrict->id,
                'parent_district'          => $parentDistrict->id,
                'account_name'             => $accountName->id,
                'member_id'                => $row['member_id'] ?? 'MISSING_ID',
                'dob'                      => $dob,
                'anniversary_date'         => $anniversaryDate,
                'salutation'               => $row['salutation'] ?? null,
                'first_name'               => $firstName,
                'last_name'                => $row['last_name'] ?? null,
                'suffix'                   => $row['suffix'] ?? null,
                'spouse_name'              => $row['spouse_name'] ?? null,
                'mailing_address_line_1'   => $row['mailing_address_line_1'] ?? null,
                'mailing_address_line_2'   => $row['mailing_address_line_2'] ?? null,
                'mailing_city'             => $row['mailing_city'] ?? null,
                'mailing_state'            => $row['mailing_state'] ?? null,
                'mailing_country'          => $row['mailing_country'] ?? null,
                'mailing_zip'              => $row['mailing_zip'] ?? null,
                'preferred_email'          => $row['preferred_email'] ?? null,
                'email_address'            => $row['email_address'] ?? null,
                'work_email'               => $row['work_email'] ?? null,
                'preferred_phone'          => $row['preferred_phone'] ?? 'Mobile',
                'phone_number'             => $row['phone_number'] ?? null,
                'work_number'              => $this->sanitizeWorkNumber($row['work_number'] ?? null),
                'home_number'              => $row['home_number'] ?? null,
                'fax'                      => $row['fax'] ?? null,
                'membership_full_type'     => $membershipFullType->id,
                'profile_photo'            => $row['profile_photo'] ?? null,
                'password'                 => Hash::make('1234'),
                'created_at'               => now(),
                'updated_at'               => now()
            ];
        }

        if (!empty($batchData)) {
            Member::insert($batchData);
            Log::info("Inserted batch of " . count($batchData) . " members.");
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }

    private function formatDate($date)
    {
        if (!empty($date)) {
            try {
                return Carbon::createFromFormat('d/m/Y', trim($date))->format('Y-m-d');
            } catch (\Exception $e) {
                Log::warning("Invalid date format: {$date}");
                return null;
            }
        }
        return null;
    }

    private function sanitizeWorkNumber($workNumber)
    {
        if ($workNumber && strlen($workNumber) > 50) {
            Log::warning("Trimming work_number: " . $workNumber);
            return substr($workNumber, 0, 50);
        }
        return $workNumber;
    }
}
