<?php

namespace App\View\Composers;

use App\View\Composers\Concerns\MapsAcfFields;
use Roots\Acorn\View\Composer;

class App extends Composer
{
    use MapsAcfFields;

    protected static $views = [
        '*',
    ];

    public function with(): array
    {
        $fields = $this->acf('option');
        $logo = $fields['logo'] ?? null;
        $phone = $fields['phone'] ?? '780 555 5555';
        $digits = preg_replace('/[^\d+]/', '', (string) $phone);
        $legal = $fields['footerLegal'] ?? '© {year} Progressive Electrical Services Inc. All rights reserved.';

        return array_merge([
            'loginUrl' => 'https://app.progressiveelectrical.ca',
            'loginLabel' => 'Login',
            'phone' => '780 555 5555',
            'email' => 'admin@pespower.ca',
            'hours' => '7am–5pm',
            'address' => "6040 Gateway Boulevard NW<br>Edmonton, Alberta T6H 2H6",
            'footerCompany' => 'Progressive Electrical Services Inc.',
            'footerBusinessesHeading' => 'General inquiries',
            'footerBusinessesLabel' => 'Employee login',
            'footerQuotesHeading' => 'Estimating & Tenders',
            'estimatingEmail' => 'estimating@pespower.ca',
        ], $fields, [
            'siteName' => get_bloginfo('name', 'display'),
            'logoUrl' => $this->imageUrl($logo),
            'logoAlt' => $this->imageAlt($logo) ?: get_bloginfo('name', 'display'),
            'appUrl' => $fields['loginUrl'] ?? 'https://app.progressiveelectrical.ca',
            'phoneHref' => $digits ? 'tel:'.$digits : '',
            'footerLegal' => str_replace('{year}', (string) date('Y'), $legal),
        ]);
    }
}
