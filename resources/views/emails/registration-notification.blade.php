<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Registration - Artisan Skills Training</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #3B82F6; color: white; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
        .content { background: #f8f9fa; padding: 20px; border-radius: 0 0 8px 8px; }
        .section { background: white; margin: 10px 0; padding: 15px; border-radius: 6px; border-left: 4px solid #3B82F6; }
        .section h3 { margin-top: 0; color: #1f2937; }
        .details { display: grid; grid-template-columns: 1fr 2fr; gap: 10px; }
        .details dt { font-weight: bold; color: #4b5563; }
        .details dd { margin: 0; }
        .interests, .knowledge { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 5px; }
        .tag { background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .footer { text-align: center; margin-top: 20px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Training Registration</h1>
        <p>Spotlight Consultancy - Artisan Skills Training Program</p>
    </div>

    <div class="content">
        <div class="section">
            <h3>Registrant Information</h3>
            <dl class="details">
                <dt>Name:</dt>
                <dd>{{ $user->fullName() }}</dd>
                
                <dt>Phone:</dt>
                <dd>{{ $user->phone }}</dd>
                
                @if($user->email)
                <dt>Email:</dt>
                <dd>{{ $user->email }}</dd>
                @endif
                
                <dt>Location:</dt>
                <dd>{{ $user->location }}</dd>
                
                <dt>Registration Status:</dt>
                <dd><strong>{{ ucfirst($user->registration_status) }}</strong></dd>
                
                <dt>Registered At:</dt>
                <dd>{{ $user->created_at->format('F j, Y \a\t g:i A') }}</dd>
            </dl>
        </div>

        <div class="section">
            <h3>Areas of Interest</h3>
            <div class="interests">
                @foreach($user->interests as $interest)
                    <span class="tag">
                        @switch($interest)
                            @case('graphic_design') Graphic Design @break
                            @case('large_format_printing') Large Format Printing @break
                            @case('embroidery_digitization') Embroidery & Digitization @break
                            @case('screen_printing') Screen Printing @break
                            @case('signage_branding') Signage & Branding @break
                            @case('machine_troubleshooting') Machine Troubleshooting @break
                            @default {{ $interest }}
                        @endswitch
                    </span>
                @endforeach
            </div>
        </div>

        <div class="section">
            <h3>Current Knowledge & Experience</h3>
            <div class="knowledge">
                @foreach($user->current_knowledge as $knowledge)
                    <span class="tag">
                        @switch($knowledge)
                            @case('computer_basic') Basic Computer Skills @break
                            @case('computer_intermediate') Intermediate Computer Skills @break
                            @case('computer_advanced') Advanced Computer Skills @break
                            @case('printing_experience') Previous Printing Experience @break
                            @case('design_experience') Design Experience @break
                            @case('business_experience') Business/Entrepreneurship Experience @break
                            @case('none') No Prior Experience @break
                            @default {{ $knowledge }}
                        @endswitch
                    </span>
                @endforeach
            </div>
        </div>

        <div class="section">
            <h3>Next Steps</h3>
            <ul>
                <li><strong>Contact within 24 hours</strong> - Reach out to {{ $user->fullName() }} via phone at {{ $user->phone }}</li>
                @if($user->email)
                <li>Email confirmation can be sent to {{ $user->email }}</li>
                @endif
                <li>Verify phone number if needed</li>
                <li>Discuss payment arrangements (MWK 300,000)</li>
                <li>Schedule initial orientation session</li>
                <li>Provide program details and start date</li>
            </ul>
        </div>

        <div class="section">
            <h3>Program Details</h3>
            <dl class="details">
                <dt>Duration:</dt>
                <dd>6 months</dd>
                
                <dt>Fee:</dt>
                <dd>MWK 300,000</dd>
                
                <dt>Location:</dt>
                <dd>Area 45, Chinsapo, Opposite Tachira Pvt Clinic, Lilongwe</dd>
                
                <dt>Training Type:</dt>
                <dd>Hands-on consultancy program</dd>
            </dl>
        </div>
    </div>

    <div class="footer">
        <p>This is an automated notification from the Spotlight Consultancy registration system.</p>
        <p>Generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>
</body>
</html>