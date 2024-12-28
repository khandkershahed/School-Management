@extends('emails.email_app')
@section('email-body')
    <tr>
        <td class="email-body" width="570" cellpadding="0" cellspacing="0">
            <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                <!-- Body content -->
                <tr>
                    <td class="content-cell">
                        <div class="f-fallback">
                            <h1>Hi {{ ucfirst($user->name) }}, good day!</h1>
                            <p>Welcome to {{ !empty(optional($setting)->website_name) ? optional($setting)->website_name : 'AMS' }}! Thank you for being a part of our company.
                                Hope we are going to have a good business relationship together! Have a nice day.</p>
                            <p>Thanks,
                                <br>{{ !empty(optional($setting)->website_name) ? optional($setting)->website_name : 'AMS' }}<br />
                                {{ !empty(optional($setting)->info_email) ? optional($setting)->info_email : '' }}
                            </p>
                            <!-- Sub copy -->
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
