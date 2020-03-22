@extends('layouts.master')
@section('title', 'Guidance and Templates - ')
@section('content')
@include('layouts.navbar')
<div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
<div class="eight column wide">
<a href="{{URL::previous()}}">◀ Go Back</a><br>
<h1 class="ui header">Guidance and Templates</h1>
<h4>Strike Lengths</h4>
<table class="ui celled table">
    <thead>
        <tr>
            <th>Strike</th>
            <th>Length</th>
            <th>Probationary Period</th>
            <th>Ban end date</th>
            <th>Probation end date</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1st</td>
            <td>24 hours</td>
            <td>30 days</td>
            <td>{{Carbon\Carbon::now()->addDay()->toDayDateTimeString()}} GMT</td>
            <td>{{Carbon\Carbon::now()->addDays(31)->toDayDateTimeString()}} GMT</td>
        </tr>
        <tr>
            <td>2nd</td>
            <td>7 days</td>
            <td>90 days</td>
            <td>{{Carbon\Carbon::now()->addDays(7)->toDayDateTimeString()}} GMT</td>
            <td>{{Carbon\Carbon::now()->addDays(97)->toDayDateTimeString()}} GMT</td>
        </tr>
        <tr>
            <td>3rd</td>
            <td>No less than 28 days (Quad decision)</td>
            <td>180 days</td>
            <td>No earlier than {{Carbon\Carbon::now()->addDays(28)->toDayDateTimeString()}} GMT</td>
            <td>{{Carbon\Carbon::now()->addDays(28)->addDays(180)->toDayDateTimeString()}} GMT</td>
        </tr>
        <tr>
            <td>4th</td>
            <td>Permanent/No less than 28 days</td>
            <td>N/A</td>
            <td>No earlier than {{Carbon\Carbon::now()->addDays(28)->toDayDateTimeString()}} GMT</td>
            <td>N/A</td>
        </tr>
    </tbody>
</table>
<a href="https://docs.google.com/document/d/1z-h1UesL2keMZT5zleSyRfQkNF6RoRwdHsZpZ4-6cJw/edit" class="fluid ui button">Full Rules and Guidance</a>
<h4>Templates</h4>
<p>Replace highlighted sections with required information.</p>
<div class="ui styled fluid accordion">
    <div class="title">
        <i class="dropdown icon"></i>
        Notice of informal warning
    </div>
    <div class="content">
        <p>
            This is an informal warning regarding your behaviour in the MHOC Main Server. This has been issued because <span class="ui red text">reason.</span> Subsequently, you have been muted in the Server for <span class="ui red text">number of minutes</span> minutes to allow the situation to calm down / you to consider the potential ramifications should you continue with this behaviour.
        </p>
        <p>
            This is a precautionary measure and will have no bearing on you moving forward. However, we ask that you take this warning seriously and adjust your behaviour upon your return to prevent you from breaking any rules and subsequently receiving a formal strike.
        </p>
    </div>
    <div class="title">
        <i class="dropdown icon"></i>
        Notice of 1st strike
    </div>
    <div class="content">
        <p>
            This is a notice to inform you of your first strike on the MHOC Main Server. This subsequently means that you have been banned from the server for 24 hours, and will be on probation for a period of 30 days following your return. Your return date will be <span class="ui red text">return date at time to the nearest hour</span>, and so your probationary period will end <span class="ui red text">probation end date</span> (30 days following return).
        </p>
        <p>
            You received this strike because you <span class="ui red text">reason.</span> Evidence for this is linked below.
        </p>
        <p>
            If you have any queries about this strike and what it means, or if you wish to appeal this decision, then please contact the Quadrumvirate via mod-mail to /r/MHOCQuad.
        </p>
        <p>
            <span class="ui red text">(Link evidence here)</span>
        </p>
    </div>
    <div class="title">
        <i class="dropdown icon"></i>
        Notice of 2nd strike
    </div>
    <div class="content">
        <p>
            This is a notice to inform you of your second strike on the MHOC Main Server. This subsequently means that you have been banned from the server for 7 days, and will be on probation for a period of 90 days following your return. Your return date will be <span class="ui red text">return date at time to the nearest hour</span>, and so your probationary period will end <span class="ui red text">probation end date</span> (90 days following return).
        </p>
        <p>
            You received this strike because you <span class="ui red text">reason.</span> Evidence for this is linked below.
        </p>
        <p>
            If you have any queries about this strike and what it means, or if you wish to appeal this decision, then please contact the Quadrumvirate via mod-mail to /r/MHOCQuad.
        </p>
        <p>
            <span class="ui red text">(Link evidence here)</span>
        </p>
    </div>
    <div class="title">
        <i class="dropdown icon"></i>
        Notice of 2nd strike having skipped 1st strike
    </div>
    <div class="content">
        <p>
            This is a notice to inform you of your second strike on the MHOC Main Server. Despite not having a received a 1st strike prior to this, it was decided within the Discord Moderation Team that your actions have warranted an instant 2nd strike. This subsequently means that you have been banned from the server for 7 days, and will be on probation for a period of 90 days following your return. Your return date will be <span class="ui red text">return date at time to the nearest hour</span>, and so your probationary period will end <span class="ui red text">probation end date</span> (90 days following return).
        </p>
        <p>
            You received this strike because you <span class="ui red text">reason.</span> Evidence for this is linked below.
        </p>
        <p>
            If you have any queries about this strike and what it means, or if you wish to appeal this decision, then please contact the Quadrumvirate via mod-mail to /r/MHOCQuad.
        </p>
        <p>
            <span class="ui red text">(Link evidence here)</span>
        </p>
    </div>
    <div class="title">
        <i class="dropdown icon"></i>
        Notice of 3rd strike and final warning
    </div>
    <div class="content">
        <p>
            This is a notice to inform you of your third strike, and thus final warning, on the MHOC Main Server. This subsequently means that you have been banned from the server for quad to determine days / months, and will be on probation for a period of 180 days following your return. Your return date will be <span class="ui red text">return date at time to the nearest hour</span>, and so your probationary period will end <span class="ui red text">probation end date</span> (180 days following return).
        </p>
        <p>
            I must note that a fourth active strike can result in your permanent ban from the MHOC Main Server.
        </p>
        <p>
            You received this strike because you <span class="ui red text">reason.</span> Evidence for this is linked below.
        </p>
        <p>
            If you have any queries about this strike and what it means, or if you wish to appeal this decision, then please contact the Quadrumvirate via mod-mail to /r/MHOCQuad.
        </p>
        <p>
            <span class="ui red text">(Link evidence here)</span>
        </p>
    </div>
    <div class="title">
        <i class="dropdown icon"></i>
        Notice of 4th strike and permanent ban
    </div>
    <div class="content">
        <p>
            This is a notice to inform you of your fourth strike on the MHOC Main Server. This subsequently means that you have been permanently banned from the server.
        </p>
        <p>
            You received this strike because you <span class="ui red text">reason.</span> Evidence for this is linked below.
        </p>
        <p>
            If you have any queries about this strike and what it means, or if you wish to appeal this decision, then please contact the Quadrumvirate via mod-mail to /r/MHOCQuad.
        </p>
        <p>
            <span class="ui red text">(Link evidence here)</span>
        </p>
    </div>
    <div class="title">
        <i class="dropdown icon"></i>
        Notice of 4th strike but no permanent ban
    </div>
    <div class="content">
        <p>
            This is a notice to inform you of your fourth strike on the MHOC Main Server. A fourth active strike would normally warrant a permanent ban from the server, but following a review of your recent behaviour, the circumstances surrounding this strike, and for other reasons, we have decided to not issue you with a permanent ban.
        </p>
        <p>
            However, we must stress that if you were to commit another offence under MHOC’s Discord policy, it is highly likely that your chances of avoiding a permanent ban would be extremely minimal.
        </p>
        <p>
            As previously stated you will not receive a permanent ban for this strike but you will be dealt the punishment as would apply if this was a 3rd strike which is a ban of <span class="ui red text">number of days decided upon by the Quad</span> and a probation period upon your return of 180 days - a restart of your current probationary period. Your return date will be <span class="ui red text">return date at time to the nearest hour</span>, and so your probationary period will end <span class="ui red text">probation end date</span> (180 days following return).
        </p>
        <p>
            You received this strike because you <span class="ui red text">reason.</span> Evidence for this is linked below.
        </p>
        <p>
            If you have any queries about this strike and what it means, or if you wish to appeal this decision, then please contact the Quadrumvirate via mod-mail to /r/MHOCQuad.
        </p>
        <p>
            <span class="ui red text">(Link evidence here)</span>
        </p>
    </div>
    <div class="title">
        <i class="dropdown icon"></i>
        Notice of strike overturned
    </div>
    <div class="content">
        <p>
            This is a notice to inform you that the strike that you received on <span class="ui red text">dd mmmmmmm yyyy</span> for <span class="ui red text">select the relevant option from the table below<, if other then state this reason</span> has been overturned as the result of a <span class="ui red text">successful appeal OR reconsideration of the initial decision.</span>
        </p>
        <p>
            Your ban from the MHOC Main Server has therefore been withdrawn and full access to chats has been reinstated. Any probationary period put in place will also be revoked.
        </p>
        <p>
            Please accept the Moderation Team’s apology for any inconvenience caused, we just aim to be proactive in protecting members of the community and so sometimes mistakes are made.
        </p>
        <p>
            If you have any queries regarding this message, then please contact the Quadrumvirate.
        </p>
        <p>
            <span class="ui red text">(Link evidence here)</span>
        </p>
    </div>
</div>
<script>
    $('.ui.accordion')
  .accordion()
;
</script>
</div>
</div>
@endsection
