@extends('layouts.app')
@section('title', 'Map Companies | YellowShare')
@section('content')
<div class="page_container">
    @if (session('success'))
    <div class="alert alert-success">
        <center><i class="fa fa-check-circle" aria-hidden="true"></i> {{ session('success') }}</center>
    </div>
    @endif
    @if (session('failed'))
    <div class="alert alert-danger">
        <center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ session('failed') }}
        </center>
    </div>
    @endif

    <div class="col-md-12">
        <form id="first-form" method="POST" action="{{ route('map-company-details') }}">
            @csrf
            <input type="hidden" name="id" value="{{ request()->route('companyid') }}">
            <div class="form-group">
                <label for="Select category">Select Company:</label>
                <div class="select2-purple">
                    <select class="select2" multiple="multiple" data-placeholder="Select a company" name="companies_id[]" style="width: 100%;">
                        <option value="">Select Companies</option> 
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>

    <div id="second-form" style="display: none;">
        <form>
            <!-- Second form content goes here -->
          <form method="POST" action="{{ route('download', ['companyid' => request()->route('companyid')]) }}">

            @csrf
           
           <input type="hidden" name="id" value="{{ request()->route('companyid') }}">
           
           
 <div class="col-md-4">
    <div class="form-group">
        <label for="Select tag">Select Year:</label>
        <select name="years[]" id="tag_id" class="form-control select2" multiple="multiple" data-placeholder="Select the year" style="width: 100%;">
            <option value="">Select year</option>
            @php
                $currentYear = date('Y');
                for ($i = $currentYear; $i >= $currentYear - 49; $i--) {
                    $yearRange = ($i - 1) . '-' . $i;
                    echo '<option value="' . $yearRange . '">' . $yearRange . '</option>';
                }
            @endphp
        </select>
    </div>
</div>

           
            <div class="col-md-4">
                <div class="form-group">
                   <button type="submit" class="btn btn-primary">Download Excel</button>
                </div>
            </div>
           
           
        </form>

                <!-- <a clas="btn btn-success" href="{{URL('export-company-data',$company->id)}}"><button>Export Company</button></a> -->

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var firstForm = document.getElementById('first-form');
        var secondForm = document.getElementById('second-form');

        firstForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission
            firstForm.style.display = 'none'; // Hide the first form
            secondForm.style.display = 'block'; // Show the second form
        });
    });
</script>

@endsection
