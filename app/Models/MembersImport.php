<?php
namespace App\Imports;

use App\Models\Member;
use App\Models\Chapter;
use App\Models\District;
use App\Models\MembershipType;
use App\Models\ParentsMultipleDistrict;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Trim values to prevent empty spaces causing NULL errors
        $firstName = isset($row['first_name']) ? trim($row['first_name']) : null;

        // Check if first_name is missing
        if (empty($firstName)) {
            Log::error("Missing first_name for row: " . json_encode($row));
            return null; // Skip this row
        }

        // Handle Parent Multiple District
        $parentMultipleDistrict = ParentsMultipleDistrict::firstOrCreate(
            ['name' => trim($row['parent_multiple_district'] ?? '')],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Handle Parent District
        $parentDistrict = District::firstOrCreate(
            ['name' => trim($row['parent_district'] ?? '')],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Handle Account Name (Chapter)
        $accountName = Chapter::firstOrCreate(
            ['chapter_name' => trim($row['account_name'] ?? '')],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Handle Membership Type
        $membershipFullType = MembershipType::firstOrCreate(
            ['name' => trim($row['membership_full_type'] ?? '')],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Handle Date Conversion Safely
        $dob = $this->formatDate($row['dob'] ?? null);
        $anniversaryDate = $this->formatDate($row['anniversary_date'] ?? null);

        return new Member([
            'parent_multiple_district' => $parentMultipleDistrict->id,
            'parent_district'          => $parentDistrict->id,
            'account_name'             => $accountName->id,
            'member_id'                => $row['member_id'] ?? 'MISSING_ID',
            'dob'                      => $dob,
            'anniversary_date'         => $anniversaryDate,
            'salutation'               => $row['salutation'] ?? null,
            'first_name'               => $firstName, // Ensured to be non-empty
            'last_name'                => $row['last_name'] ?? null,
            'suffix'                   => $row['suffix'] ?? null,
            'spouse_name'              => $row['spouse_name'] ?? null,
            'mailing_address_line_1'   => $row['mailing_address_line_1'] ?? null,
            'mailing_address_line_2'   => $row['mailing_address_line_2'] ?? null,
            'mailing_address_line_3'   => $row['mailing_address_line_3'] ?? null,
            'mailing_city'             => $row['mailing_city'] ?? null,
            'mailing_state'            => $row['mailing_state'] ?? null,
            'mailing_country'          => $row['mailing_country'] ?? null,
            'mailing_zip'              => $row['mailing_zip'] ?? null,
            'preferred_email'          => $row['preferred_email'] ?? null,
            'email_address'            => $row['email_address'] ?? null,
            'work_email'               => $row['work_email'] ?? null,
            'alternate_email'          => $row['alternate_email'] ?? null,
            'preferred_phone'          => $row['preferred_phone'] ?? 'Mobile', // Default if null
            'phone_number'             => $row['phone_number'] ?? null,
            'work_number'              => $row['work_number'] ?? null,
            'home_number'              => $row['home_number'] ?? null,
            'fax'                      => $row['fax'] ?? null,
            'membership_full_type'     => $membershipFullType->id,
            'profile_photo'            => $row['profile_photo'] ?? null,
        ]);
    }

    /**
     * Format date safely from 'd/m/Y' to 'Y-m-d'
     */
    private function formatDate($date)
    {
        if (!empty($date)) {
            try {
                return Carbon::createFromFormat('d/m/Y', trim($date))->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }
}
