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

        $data = array_merge([
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
            'servicesEyebrow' => "What we're good at",
            'servicesTitle' => 'Services & Expertise',
            'services' => $this->defaultServices(),
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

        $data['services'] = $this->mapServices($data['services'] ?? []);

        return $data;
    }

    protected function mapServices(array $items): array
    {
        return array_values(array_filter(array_map(function ($item) {
            $title = trim((string) ($item['title'] ?? ''));

            if ($title === '') {
                return null;
            }

            $content = trim((string) ($item['content'] ?? ''));

            if ($content === '') {
                $content = $this->legacyServiceContent($item);
            }

            return [
                'title' => $title,
                'slug' => sanitize_title($title),
                'content' => $content,
            ];
        }, $items)));
    }

    protected function legacyServiceContent(array $item): string
    {
        $intro = trim((string) ($item['intro'] ?? ''));
        $paragraphs = array_values(array_filter(array_map('trim', preg_split('/\R\s*\R/', $intro) ?: [])));
        $points = $item['points'] ?? [];

        if (is_string($points)) {
            $list = preg_split('/\R/', $points) ?: [];
        } else {
            $list = array_map(function ($point) {
                return is_array($point) ? (string) ($point['point'] ?? '') : (string) $point;
            }, $points);
        }

        $list = array_values(array_filter(array_map('trim', $list)));
        $closing = trim((string) ($item['closing'] ?? ''));
        $html = '';

        foreach ($paragraphs as $para) {
            $html .= '<p>'.esc_html($para).'</p>';
        }

        if ($list) {
            $html .= '<ul>';

            foreach ($list as $point) {
                $html .= '<li>'.esc_html($point).'</li>';
            }

            $html .= '</ul>';
        }

        if ($closing !== '') {
            $html .= '<p>'.esc_html($closing).'</p>';
        }

        return $html;
    }

    protected function defaultServices(): array
    {
        return [
            [
                'title' => 'Preconstruction Budgeting and Estimating',
                'intro' => 'Strong projects begin with clear scope, reliable information and informed decisions. Progressive provides practical preconstruction support that helps clients understand electrical requirements, set realistic budgets and see risks before construction begins.',
                'points' => [
                    'Conceptual, Class C and Class B budgeting',
                    'Detailed tender and construction estimating',
                    'Drawing, specification and scope reviews',
                    'Lump-sum pricing and schedule of values',
                    'Progress billing and cash-flow planning',
                    'Constructability and risk assessments',
                    'Value engineering and cost-saving alternatives',
                    'Procurement planning and long-lead equipment review',
                ],
                'closing' => 'Involved early, we reduce uncertainty and set a clear financial and operational path from planning through construction.',
            ],
            [
                'title' => 'Design Build & Design Assist Support',
                'intro' => "Successful design-build and design-assist projects depend on early collaboration, clear communication and the right expertise at every stage. Progressive brings together owners, consultants, general contractors, engineers, manufacturers, suppliers and agency representatives to build an integrated electrical team around the specific needs of each project.\n\nFor design-build projects, Progressive can assemble and coordinate the electrical design team, including trusted engineering partners. Our team develops the practical system layouts, equipment requirements, schedules, budgets and construction details in close collaboration with the engineer. The engineer provides professional oversight, technical review, permit-ready documentation and required site reviews, creating an efficient process that respects professional responsibilities while reducing duplicated effort and unnecessary design costs.\n\nOur established relationships with engineers, manufacturers, suppliers and local representatives provide early access to technical expertise, current product information, accurate budgeting and procurement insight. This allows the project team to evaluate options earlier, resolve challenges faster and select solutions based on availability, performance, lifecycle value and overall project requirements.",
                'points' => [
                    'Electrical design-team assembly and coordination',
                    'Trusted engineering and technical partnerships',
                    'Early electrical planning and system development',
                    'Practical layout, equipment and schedule development',
                    'Progressive budgeting and cost validation during design',
                    'Drawing, specification and constructability reviews',
                    'System selection, value engineering and lifecycle considerations',
                    'Coordination with owners, consultants and other trades',
                    'Utility servicing, equipment and infrastructure coordination',
                    'Manufacturer, supplier and agency engagement',
                    'Code, permitting and authority requirement reviews',
                    'Procurement strategies for long-lead equipment',
                    'Design progression, scope and cost tracking',
                ],
                'closing' => 'Progressive combines practical construction knowledge with trusted professional and industry partnerships to deliver coordinated, buildable electrical designs with greater cost certainty, stronger procurement planning and fewer surprises during construction.',
            ],
            [
                'title' => 'Commercial / Light Industrial Electrical Construction',
                'intro' => "Progressive delivers complete electrical contracting services for commercial, institutional and light industrial projects across Western Canada. From new construction and major renovations to complex work within occupied facilities, our team provides the planning, field leadership and technical capability required to execute safely, efficiently and with minimal disruption.\n\nOur experience includes healthcare facilities, offices, retail environments, warehouses and distribution centres, community facilities, senior living developments and secure government installations. We support tendered, negotiated, design-build and design-assist projects, adapting our construction approach, manpower planning and sequencing to the facility, schedule and client's operational priorities.\n\nProgressive manages each project from mobilization through testing, commissioning and closeout. Clear communication connects clients, consultants, general contractors, suppliers and field teams, while experienced supervision and disciplined project controls keep scope, schedule, cost and responsibilities aligned throughout construction.\n\nOur structured digital document-control and internal management systems provide clear visibility into current drawings, shop drawings, procurement, change requests, project decisions and outstanding action items. This keeps information organized and accessible, improves accountability between the office and field, and helps the project team identify and resolve issues before they affect construction.",
                'points' => [
                    'New commercial and light industrial construction',
                    'Tenant improvements and major interior renovations',
                    'Occupied-facility, phased and off-hours construction',
                    'Electrical services, distribution and metering',
                    'Main distribution, panels, transformers and transfer systems',
                    'Standby generators and emergency power systems',
                    'Lighting, lighting controls and energy upgrades',
                    'Fire alarm and life-safety systems',
                    'Data and communications infrastructure',
                    'Access control, CCTV and intrusion systems',
                    'Public-address, intercom and sound systems',
                    'Electric-vehicle charging infrastructure',
                    'Mechanical equipment connections and controls',
                    'Site services, underground distribution and exterior lighting',
                    'Grounding and bonding systems',
                    'Cable tray, conduit and raceway systems',
                    'Electric heating and heat-tracing systems',
                    'Digital document control and project tracking',
                    'Testing, commissioning, deficiency management and closeout',
                ],
                'closing' => 'Progressive combines experienced project management, skilled field leadership, dependable trade partnerships and effective internal systems to deliver electrical installations built for safety, performance and long-term reliability.',
            ],
            [
                'title' => 'Service & Preventative Maintenance',
                'intro' => "Progressive provides responsive electrical service and structured preventive-maintenance support for commercial, institutional and light industrial facilities. Our team works with facility managers, building operators and property owners to resolve immediate electrical concerns and support the long-term reliability of their systems.\n\nOur service capabilities range from troubleshooting and emergency repairs to planned shutdowns, equipment maintenance, system modifications and smaller construction projects. For clients with ongoing facility requirements, Progressive can establish a tailored maintenance program based on equipment needs, operating conditions, service history and client priorities.\n\nService work is documented and communicated clearly, giving clients an organized record of completed repairs, outstanding recommendations and upcoming maintenance requirements. Where deficiencies are identified through a separate facility or compliance inspection, our service team can develop pricing, coordinate corrective work and confirm completion.",
                'points' => [
                    'Responsive electrical service and troubleshooting',
                    'Emergency repairs and service response',
                    'Planned shutdowns and electrical maintenance',
                    'Preventive-maintenance programs',
                    'Electrical repairs and equipment replacement',
                    'Lighting and lighting-control maintenance',
                    'Emergency and exit-lighting maintenance',
                    'Fire alarm repairs and deficiency correction',
                    'Distribution and power-equipment maintenance',
                    'Electrical system modifications and upgrades',
                    'Tenant improvements and smaller construction projects',
                    'Maintenance scheduling and service documentation',
                    'Corrective-work planning and budget development',
                ],
                'closing' => 'Progressive provides dependable service backed by organized planning, clear documentation and experienced electrical professionals—helping clients reduce disruptions, extend equipment life and maintain safe, reliable facilities.',
            ],
            [
                'title' => 'Client Partnerships',
                'intro' => "Progressive builds long-term client relationships through transparency, consistency and dependable follow-through. We take the time to understand each client's operations, facilities, standards and priorities so we can provide practical support that extends beyond a single project.\n\nEarly involvement allows our team to assist with upcoming project planning, preliminary budgeting, procurement considerations, facility requirements and construction strategy. As the relationship develops, Progressive retains valuable knowledge of the client's systems, preferences and past decisions, improving continuity and reducing the time required to plan and deliver future work.\n\nOur established relationships with engineers, manufacturers, suppliers, agents and specialty trade partners allow us to bring the right expertise into each project. Clients receive coordinated support, informed recommendations and access to a broader technical network through one accountable electrical partner.",
                'points' => [
                    'Long-term client and facility support',
                    'Early project planning and budget development',
                    'Preliminary scope and feasibility discussions',
                    'Support across multiple projects and facilities',
                    'Client-specific standards and preferences',
                    'Consistent estimating and project-delivery teams',
                    'Engineering, manufacturer and supplier coordination',
                    'Procurement and market-condition guidance',
                    'Transparent communication and decision tracking',
                    'Ongoing project and capital-planning support',
                    'Post-project follow-up and continued service',
                ],
                'closing' => 'Progressive approaches every relationship as a long-term partnership—providing honest guidance, responsive support and consistent accountability from the earliest conversation through construction and ongoing facility operations.',
            ],
            [
                'title' => 'Annual Electrical / FA & Thermal Inspections',
                'intro' => "Progressive provides structured electrical, fire alarm and thermal inspection services that help facility owners understand system condition, identify safety concerns and plan corrective work before deficiencies lead to disruption or equipment failure.\n\nEach inspection is tailored to the facility and documented through a consistent review process. Electrical equipment and life-safety systems are assessed for visible damage, operating condition, accessibility, identification, overheating, installation concerns and other observable deficiencies. Findings are supported by clear descriptions, photographs where appropriate, recommended actions and risk-based priorities.\n\nProgressive organizes the results into a practical facility report and consolidated deficiency log. Immediate safety or operational concerns are clearly identified, while lower-priority items can be incorporated into future maintenance and capital plans. Budget allowances can also be developed to help clients prioritize work and forecast upcoming expenditures.",
                'points' => [
                    'Annual and scheduled electrical facility inspections',
                    'Electrical distribution and power-equipment assessments',
                    'Fire alarm testing and annual inspections',
                    'Emergency and exit-lighting inspections',
                    'Infrared thermal imaging of electrical equipment',
                    'Lighting-system and lighting-level reviews',
                    'Equipment identification and asset documentation',
                    'Visual reviews for damage, overheating and installation concerns',
                    'Code and life-safety deficiency identification',
                    'Photographic documentation and equipment records',
                    'Risk-based deficiency classification',
                    'Recommended corrective actions and priorities',
                    'Budget development for identified deficiencies',
                    'Consolidated facility reports and deficiency logs',
                ],
                'closing' => 'Progressive turns inspection findings into clear, usable information—helping clients address immediate concerns, support compliance requirements and plan future electrical investments with confidence.',
            ],
        ];
    }
}
