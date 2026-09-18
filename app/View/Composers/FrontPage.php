<?php

namespace App\View\Composers;

use App\View\Composers\Concerns\MapsAcfFields;
use Illuminate\Support\Facades\Vite;
use Roots\Acorn\View\Composer;

class FrontPage extends Composer
{
    use MapsAcfFields;

    protected static $views = [
        'front-page',
    ];

    public function with(): array
    {
        $fields = $this->acf();

        return array_merge([
            'heroTitle' => 'Contributing to Transparency in Construction.',
            'heroLede' => 'A line about being in Edmonton, and the services that are actually provided, and the areas that PES offer them.',
            'heroCtaLabel' => 'Get in touch',
            'heroCtaUrl' => '#contact',
            'beyondEyebrow' => 'Fresh, but not new',
            'beyondTitle' => 'Alberta Wide & Beyond',
            'beyondCopy' => '<p>This is where you can cut through some of the vague mission and values-speak, and help people (and search engines) pickup on the straightforward facts of what kind of projects Progressive takes on.</p><p>Help the viewer match the fit. Figure out if this is where they’re supposed to be. We’re not wiring up basements.</p><p>Or are we?</p>',
            'stats' => [
                ['label' => '100+ years combined experience', 'icon' => null],
                ['label' => 'Active and involved in our community', 'icon' => null],
                ['label' => 'Something related to transparency', 'icon' => null],
                ['label' => 'Our place in the industry, perhaps?', 'icon' => null],
            ],
            'communityPartnersHeading' => 'Community Partners',
            'communityPartners' => [
                ['name' => 'YESS', 'logo' => null, 'url' => ''],
                ['name' => 'Mental Health Foundation', 'logo' => null, 'url' => ''],
                ['name' => 'Stollery', 'logo' => null, 'url' => ''],
            ],
            'supportOrgsHeading' => 'Organizations we support',
            'supportOrgs' => [],
            'credentialsHeading' => '',
            'credentials' => [
                ['name' => 'Edmonton Construction Association', 'logo' => null, 'url' => ''],
                ['name' => 'Electrical Contractors Association of Alberta', 'logo' => null, 'url' => ''],
                ['name' => 'Alberta Construction Safety Association', 'logo' => null, 'url' => ''],
                ['name' => 'Certificate of Recognition', 'logo' => null, 'url' => ''],
                ['name' => 'Alberta Electrical Alliance', 'logo' => null, 'url' => ''],
                ['name' => 'Technical Safety BC', 'logo' => null, 'url' => ''],
            ],
            'credentialsLine' => 'Licensed in AB, BC & SK | COR Certified | Fully Insured | Bondable | WCB Compliant',
            'platformsHeading' => 'Project platforms',
            'platforms' => [],
            'contactEyebrow' => 'Always a good idea',
            'contactTitle' => 'You know what to do. Pretty sure.',
            'contactIntro' => "Our headquarters are in Edmonton. Let us know.<br>We’re here 7am–5pm.",
            'contactCtaLabel' => 'Get in touch',
        ], $fields, [
            'heroMark' => Vite::asset('resources/images/Big-P.svg'),
            'heroBackground' => $this->imageUrl($fields['heroBackground'] ?? null),
            'mapboxToken' => env('MAPBOX_TOKEN', ''),
            'mapboxStyle' => env('MAPBOX_STYLE', ''),
        ]);
    }
}
