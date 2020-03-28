@extends('layouts.master')
@section('content')
@include('layouts.navbar')
<div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
<div class="eight column wide">
<h1 class="ui header">Submit Complaint</h1>
@if ($errors->any())
<div class="ui error message">
    <div class="header">
        There were some errors with your submission
    </div>
    <div class="ui bulleted list">
    @foreach ($errors->all() as $e)
        <div class="item">
            {{$e}}
        </div>
    @endforeach
    </div>
</div>
@endif

<div class="ui form">
    <form action="{{route('complaint.create.post')}}" method="POST" id="form">
    @csrf
    <h4 class="ui horizontal left aligned divider header">
        Important Information
    </h4>
    <div class="ui segment">
        <p>This form allows members of MHoC to submit <b>anonymous complaints to the Speakership</b> on moderation issues. This includes reports of members breaking rules. We will not know that it was you submitting this complaint.</p>
        <p><b>If the issue is urgent, please contact a Quadrumvirate member as soon as possible.</b></p>
    </div>
    <h4 class="ui horizontal left aligned divider header">
        Your complaint
    </h4>
    <div class="required field">
        <label for="">Subject</label>
        <input required type="text" name="subject" placeholder="">
    </div>
    <div class="required field">
        <label for="">Content</label>
        <p>Please provide evidence of your complaint. Feel free to censor identifying information. Content can be a maximum of 2000 characters, use a pastebin for further room.</p>
        <textarea required name="content" placeholder=""></textarea>
    </div>
    </form>
    <br>
    <button id="submitButton" class="ui primary button" onclick="submitForm()">Submit Complaint</button>
    <br>
    <div class="ui message" id="resultMsg" style="display:none">
        <div class="header">
        </div>
        <p></p>
    </div>
    <script>
        function submitForm () {
            $("#submitButton").toggleClass('elastic loading');
            let data = $("#form").serializeArray();
            $.ajax({
                type: 'POST',
                url: '{{route('complaint.create.post')}}',
                data: {subject:data[1].value, content:data[2].value},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': data[0].value
                },
                success: function(data) {
                    console.log(data)
                    $("#submitButton").toggleClass('elastic loading');
                    $("#resultMsg").addClass('green').removeClass('error').show();
                    $("#resultMsg .header").text(null)
                    $("#resultMsg p").text(data.message);
                },
                error: function(data) {
                    console.log(data)
                    $("#submitButton").toggleClass('elastic loading');
                    $("#resultMsg").addClass('error').removeClass('green').show();
                    $("#resultMsg .header").text('There were some errors')
                    $("#resultMsg p").text(data.responseJSON.message);
                }
            })
        }
    </script>
</div>
@endsection
