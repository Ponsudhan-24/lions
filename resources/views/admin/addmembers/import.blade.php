@extends('MasterAdmin.layout')
<style>
    .custom-btn {
        background: rgb(30,144,255);
        background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
        border: none;
        color: white !important;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 24px;
        transition: 0.3s;
    }

    .custom-btn:hover {
        background: linear-gradient(159deg, rgba(153,186,221,1) 0%, rgba(30,144,255,1) 100%);
        color: white !important;
    }
</style>



@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Import Data</h2>

        @if(session('success'))
            <div class="alert alert-success" id="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="card p-4">
            <div class="row">
                {{-- International Officers Import --}}
                <div class="col-md-6">
                    <h4>Import International Officers</h4>
                    <form action="{{ route('import.international.officers') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="text-center">
    <button type="submit" class="btn custom-btn mt-2">Import</button>
</div>
                    </form>
                </div>

                {{-- DG Team Import --}}
                <div class="col-md-6">
                    <h4>Import DG Team</h4>
                    <form action="{{ route('import.dg.team') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="text-center">
    <button type="submit" class="btn custom-btn mt-2">Import</button>
</div>
                    </form>
                </div>
            </div>

            <div class="row mt-4">
                {{-- Past Governors Import --}}
                <div class="col-md-6">
                    <h4>Import Past Governors</h4>
                    <form action="{{ route('import.past.governors') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="text-center">
    <button type="submit" class="btn custom-btn mt-2">Import</button>
</div>
                    </form>
                </div>

                {{-- District Chairpersons Import --}}
                <div class="col-md-6">
                    <h4>Import District Chairpersons</h4>
                    <form action="{{ route('import.district.chairpersons') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="text-center">
    <button type="submit" class="btn custom-btn mt-2">Import</button>
</div>
                    </form>
                </div>
            </div>

            <div class="row mt-4">
                {{-- District Governors Import --}}
                <div class="col-md-6">
                    <h4>Import District Governors</h4>
                    <form action="{{ route('import.district.governors') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="text-center">
    <button type="submit" class="btn custom-btn mt-2">Import</button>
</div>
                    </form>
                </div>

                {{-- Region Members Import --}}
                <div class="col-md-6">
                    <h4>Import Region Members</h4>
                    <form action="{{ route('import.region.members') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="text-center">
    <button type="submit" class="btn custom-btn mt-2">Import</button>
</div>
                    </form>
                </div>
            </div>

            <div class="row mt-4">
                {{-- Club Positions Import --}}
                <div class="col-md-6">
                    <h4>Import Club Positions</h4>
                    <form action="{{ route('import.club.positions') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="text-center">
    <button type="submit" class="btn custom-btn mt-2">Import</button>
</div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            let successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 3000);
    </script>
@endsection
