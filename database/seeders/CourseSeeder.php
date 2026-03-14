<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // We need a valid instructor_id (admin user acts as instructor for now)
        // First try to find the seeded admin-acting user, else use first user
        $instructor = User::first();

        if (! $instructor) {
            $this->command->warn('No users found. Run UserSeeder first.');
            return;
        }

        // Category helpers
        $pm   = Category::where('slug', 'project-management')->first();
        $ba   = Category::where('slug', 'business-analysis')->first();
        $itsm = Category::where('slug', 'it-service-management')->first();
        $ag   = Category::where('slug', 'agile-scrum')->first();
        $data = Category::where('slug', 'data-analytics')->first();
        $pt   = Category::where('slug', 'project-planning-tools')->first();
        $pdu  = Category::where('slug', 'pdu-cpd-programmes')->first();

        $courses = [

            // ─── 1. PMP ───────────────────────────────────────────────────────
            [
                'title'       => 'PMP® Certification Training',
                'slug'        => 'pmp-certification-training',
                'subtitle'    => 'Project Management Professional – Globally Recognised Expertise',
                'description' => 'The PMP® (Project Management Professional) certification is the gold standard for project managers worldwide. Our comprehensive PMP training programme equips professionals with the knowledge, tools, and techniques to lead and direct projects across any industry.

Designed and delivered by experienced industry practitioners, this course prepares you to pass the PMP exam on your first attempt while building real-world competence you can immediately apply in your role.',
                'category_id' => $pm?->id,
                'level'       => 'intermediate',
                'duration_hours' => 50,
                'duration_weeks' => 5,
                'schedule'    => 'Monday – Friday, 3:00 AM – 5:00 AM (WAT)',
                'mode'        => 'Live Online (Instructor-Led)',
                'language'    => 'English',
                'price'       => 250000,
                'currency'    => 'NGN',
                'is_featured' => true,
                'who_course_is_for' => [
                    'Project Managers and Programme Managers',
                    'Business Analysts and Change Managers',
                    'Engineers, IT Professionals, and Consultants',
                    'Professionals aspiring to leadership or project delivery roles',
                ],
                'what_you_will_learn' => [
                    'Apply global best practices in project management (Predictive, Agile & Hybrid)',
                    'Initiate, plan, execute, monitor, and close projects effectively',
                    'Develop project schedules, budgets, and performance baselines',
                    'Apply Earned Value Management (EVM) for performance tracking',
                    'Identify and manage project risks and stakeholders',
                    'Communicate effectively with teams, sponsors, and clients',
                    'Confidently prepare for and pass the PMP® certification exam',
                ],
                'course_curriculum' => [
                    'Project Management Framework',
                    'Integration, Scope, Schedule & Cost Management',
                    'Quality, Resource & Communications Management',
                    'Risk & Procurement Management',
                    'Stakeholder Management',
                    'Agile & Hybrid Approaches',
                    'People, Process & Business Environment Domains',
                ],
                'what_you_get' => [
                    'Comprehensive PMP study materials',
                    'Over 1,800 PMP-style practice questions',
                    'Exam-focused revision sessions',
                    'Real-world case studies and templates',
                    'Ongoing learning support and guidance',
                ],
                'why_train_with_us' => 'Over 14 years of delivering high-impact professional training. Trusted by leading organisations including MTN, NNPC/NAPIMS, NLNG, CBN, ARM, and PZ Cussons. Global reach with participants across Africa, Europe, and the Middle East.',
                'requirements'      => [
                    'At least 36 months of project management experience (with a 4-year degree)',
                    '35 contact hours of project management education/training',
                    'Basic familiarity with project management concepts',
                ],
                'tags' => ['PMP', 'PMI', 'Project Management', 'Certification'],
            ],

            // ─── 2. CBAP ──────────────────────────────────────────────────────
            [
                'title'       => 'CBAP® Certification Training',
                'slug'        => 'cbap-certification-training',
                'subtitle'    => 'Certified Business Analysis Professional – Senior-Level Credential',
                'description' => 'The Certified Business Analysis Professional (CBAP®) is the world\'s leading credential for senior business analysts who want to demonstrate expertise in business analysis planning, stakeholder engagement, requirements management, and solution evaluation.

Our CBAP training programme is designed to equip experienced professionals with the knowledge, techniques, and confidence required to pass the CBAP exam and excel in senior business analysis roles.',
                'category_id' => $ba?->id,
                'level'       => 'advanced',
                'duration_hours' => 50,
                'duration_weeks' => 5,
                'schedule'    => 'Weekday sessions',
                'mode'        => 'Live Instructor-Led Virtual Training',
                'language'    => 'English',
                'price'       => 220000,
                'currency'    => 'NGN',
                'is_featured' => true,
                'who_course_is_for' => [
                    'Business Analysts and Senior Business Analysts',
                    'Product Owners and Product Managers',
                    'Business Architects and Consultants',
                    'Change Managers and Transformation Leads',
                    'Professionals in IT, Digital, Finance, or Operations seeking CBAP certification',
                ],
                'what_you_will_learn' => [
                    'Apply the BABOK® Guide (v3) knowledge areas confidently',
                    'Perform enterprise analysis and align business needs with strategic objectives',
                    'Elicit, analyse, validate, and manage requirements effectively',
                    'Evaluate business solutions and drive measurable business value',
                    'Apply business analysis techniques across predictive, agile, and hybrid environments',
                    'Prepare confidently for the CBAP® certification examination',
                ],
                'course_curriculum' => [
                    'Business Analysis Planning & Monitoring',
                    'Elicitation & Collaboration',
                    'Requirements Life Cycle Management',
                    'Strategy Analysis',
                    'Requirements Analysis & Design Definition',
                    'Solution Evaluation',
                    'Stakeholder engagement and communication',
                    'Business process modelling and improvement',
                    'Requirements prioritisation and traceability',
                    'Business case development and benefits realisation',
                ],
                'what_you_get' => [
                    'Comprehensive CBAP-aligned study materials',
                    'Practice questions mapped to the CBAP exam blueprint',
                    'Real-world case studies and hands-on exercises',
                    'Exam preparation strategies and mock assessments',
                    'Ongoing tutor support throughout the programme',
                ],
                'why_train_with_us' => 'Over 14 years of delivering professional certification training across Africa, Europe, and the Middle East. Delivered by senior consultants with deep industry and business analysis expertise.',
                'requirements' => [
                    'Minimum 5 years (7,500 hours) of business analysis experience',
                    '900 hours of experience in each of 4 of the 6 BABOK knowledge areas',
                    '21 hours of professional development in the last 4 years',
                ],
                'tags' => ['CBAP', 'IIBA', 'Business Analysis', 'Certification'],
            ],

            // ─── 3. ITIL 4 ────────────────────────────────────────────────────
            [
                'title'       => 'ITIL® 4 Foundation Certification Training',
                'slug'        => 'itil-4-foundation-certification',
                'subtitle'    => 'Build Practical IT Service Management Skills for the Digital Era',
                'description' => 'The ITIL® 4 Foundation certification is the global standard for IT Service Management (ITSM), equipping professionals with the knowledge and tools to design, deliver, and continually improve IT-enabled services.

This course provides a strong grounding in the ITIL 4 framework, helping participants understand how modern IT teams can create value, improve service quality, and align IT services with business objectives.',
                'category_id' => $itsm?->id,
                'level'       => 'beginner',
                'duration_hours' => 24,
                'duration_weeks' => 1,
                'schedule'    => 'Weekday or Weekend Options',
                'mode'        => 'Live Online Instructor-Led Sessions',
                'language'    => 'English',
                'price'       => 150000,
                'currency'    => 'NGN',
                'is_featured' => true,
                'who_course_is_for' => [
                    'IT Professionals and Service Managers',
                    'IT Support, Service Desk, and Operations Teams',
                    'IT Consultants and Digital Transformation Professionals',
                    'Project Managers and Business Analysts working with IT services',
                    'Anyone seeking a globally recognised IT service management certification',
                ],
                'what_you_will_learn' => [
                    'Understand the key concepts, principles, and terminology of ITIL® 4',
                    'Explain how ITIL supports value creation through services',
                    'Apply the Service Value System (SVS) and Service Value Chain',
                    'Understand the four dimensions of service management',
                    'Apply key ITIL practices: Incident, Problem, Change, and Service Request Management',
                    'Integrate ITIL with Agile, DevOps, and Lean ways of working',
                    'Prepare confidently for the ITIL® 4 Foundation certification exam',
                ],
                'course_curriculum' => [
                    'Introduction to IT Service Management',
                    'Key Concepts of Service Management',
                    'The Four Dimensions Model',
                    'The Service Value System (SVS)',
                    'The Service Value Chain',
                    'ITIL Management Practices (General, Service, and Technical)',
                    'Continual Improvement Model',
                    'ITIL Guiding Principles',
                ],
                'what_you_get' => [
                    'Official ITIL-aligned training materials',
                    'Practice questions and exam preparation support',
                    'Real-world IT service management case studies',
                    'Practical examples linking ITIL to Agile, DevOps, and digital transformation',
                    'Tutor support throughout the training',
                ],
                'why_train_with_us' => 'Over a decade of experience delivering professional IT and business training. Industry-experienced facilitators with hands-on delivery expertise.',
                'requirements' => [
                    'No formal prerequisites — suitable for all experience levels',
                    'Basic understanding of IT or business processes is helpful',
                ],
                'tags' => ['ITIL', 'ITSM', 'IT Service Management', 'Certification'],
            ],

            // ─── 4. PMI-ACP ───────────────────────────────────────────────────
            [
                'title'       => 'PMI-ACP® Certification Training',
                'slug'        => 'pmi-acp-certification-training',
                'subtitle'    => 'Agile Certified Practitioner – Master Agile Practices',
                'description' => 'The PMI-ACP® (Agile Certified Practitioner) certification is one of the fastest-growing credentials in project management. It validates your ability to apply agile principles and practices across real-world projects.

Our PMI-ACP training programme equips professionals with a deep understanding of Agile frameworks — including Scrum, Kanban, SAFe, and Lean — and prepares you to pass the PMI-ACP exam with confidence.',
                'category_id' => $ag?->id,
                'level'       => 'intermediate',
                'duration_hours' => 40,
                'duration_weeks' => 4,
                'schedule'    => 'Weekday sessions',
                'mode'        => 'Live Online (Instructor-Led)',
                'language'    => 'English',
                'price'       => 200000,
                'currency'    => 'NGN',
                'is_featured' => true,
                'who_course_is_for' => [
                    'Project Managers seeking Agile certification',
                    'Scrum Masters and Agile Coaches',
                    'Product Owners and Product Managers',
                    'Business Analysts working in Agile environments',
                    'IT Professionals transitioning to Agile delivery',
                ],
                'what_you_will_learn' => [
                    'Apply Agile principles and values across different project contexts',
                    'Implement Scrum, Kanban, SAFe, and other Agile frameworks',
                    'Lead and facilitate Agile ceremonies and team practices',
                    'Apply Agile planning, estimation, and tracking techniques',
                    'Manage risks and stakeholders in an Agile environment',
                    'Prepare confidently for the PMI-ACP® certification exam',
                ],
                'course_curriculum' => [
                    'Agile Foundations and Manifesto',
                    'Scrum Framework and Ceremonies',
                    'Kanban and Lean Principles',
                    'SAFe and Scaled Agile Frameworks',
                    'Agile Planning, Estimation, and Velocity',
                    'Agile Risk Management',
                    'Stakeholder Engagement in Agile',
                    'PMI-ACP Exam Preparation',
                ],
                'what_you_get' => [
                    'Comprehensive PMI-ACP study materials',
                    'Practice questions and mock exams',
                    'Real-world Agile case studies and exercises',
                    'Agile tools and templates',
                    'Post-training exam support',
                ],
                'why_train_with_us' => 'Experienced Agile practitioners and PMI-certified trainers. Practical, application-focused delivery with real project scenarios.',
                'requirements' => [
                    '2,000 hours of general project experience',
                    '1,500 hours of Agile project experience',
                    '21 contact hours of Agile training',
                ],
                'tags' => ['PMI-ACP', 'Agile', 'Scrum', 'Certification'],
            ],

            // ─── 5. Data Analysis ─────────────────────────────────────────────
            [
                'title'       => 'Data Analysis Professional Training',
                'slug'        => 'data-analysis-professional-training',
                'subtitle'    => 'Transform Data into Actionable Insights',
                'description' => 'Our Data Analysis Professional Training equips participants with the practical skills to collect, clean, analyse, and visualise data to support decision-making across any industry.

From Excel and SQL to Power BI and Python, this programme covers the essential tools and techniques used by data professionals in today\'s organisations. Whether you\'re a beginner or looking to upskill, this course delivers real-world competence.',
                'category_id' => $data?->id,
                'level'       => 'beginner',
                'duration_hours' => 60,
                'duration_weeks' => 6,
                'schedule'    => 'Weekday and Weekend Options',
                'mode'        => 'Live Online (Instructor-Led)',
                'language'    => 'English',
                'price'       => 180000,
                'currency'    => 'NGN',
                'is_featured' => true,
                'who_course_is_for' => [
                    'Beginners looking to start a career in data analysis',
                    'Business Analysts and Finance professionals',
                    'Project Managers who want to leverage data insights',
                    'Marketing, Operations, and HR professionals',
                    'Anyone who works with data and wants to gain deeper insights',
                ],
                'what_you_will_learn' => [
                    'Collect, clean, and prepare data for analysis',
                    'Apply statistical methods to interpret and summarise data',
                    'Build interactive dashboards and visualisations using Power BI',
                    'Write SQL queries to extract and manipulate data',
                    'Use Excel for advanced data analysis and modelling',
                    'Apply Python for data analysis and automation',
                    'Present data-driven insights to stakeholders',
                ],
                'course_curriculum' => [
                    'Introduction to Data Analysis',
                    'Data Collection and Cleaning',
                    'Excel for Data Analysis',
                    'SQL Fundamentals',
                    'Statistical Analysis and Interpretation',
                    'Data Visualisation with Power BI',
                    'Introduction to Python for Data Analysis',
                    'Capstone Project: End-to-End Data Analysis',
                ],
                'what_you_get' => [
                    'Hands-on projects using real datasets',
                    'Training materials and reference guides',
                    'Access to tools and sample datasets',
                    'Certificate of completion',
                    'Post-training support',
                ],
                'why_train_with_us' => 'Industry practitioners with real-world data and analytics experience. Practical, project-based learning with datasets from real business contexts.',
                'requirements' => [
                    'No prior data experience required for the beginner track',
                    'Basic computer literacy and familiarity with Excel is helpful',
                ],
                'tags' => ['Data Analysis', 'Power BI', 'SQL', 'Excel', 'Python'],
            ],

            // ─── 6. Professional Scrum Master ────────────────────────────────
            [
                'title'       => 'Professional Scrum Master (PSM) Training',
                'slug'        => 'professional-scrum-master-training',
                'subtitle'    => 'Build the Skills to Lead Agile Teams with Confidence',
                'description' => 'The Professional Scrum Master (PSM) training is designed for individuals who want to master the Scrum framework and lead high-performing Agile teams.

This programme goes beyond theory — it builds practical Scrum facilitation skills, coaching capabilities, and the mindset needed to create an environment where teams thrive.',
                'category_id' => $ag?->id,
                'level'       => 'intermediate',
                'duration_hours' => 24,
                'duration_weeks' => 2,
                'schedule'    => 'Weekday or Weekend sessions',
                'mode'        => 'Live Online (Instructor-Led)',
                'language'    => 'English',
                'price'       => 160000,
                'currency'    => 'NGN',
                'is_featured' => false,
                'who_course_is_for' => [
                    'Aspiring and practising Scrum Masters',
                    'Project Managers transitioning to Agile',
                    'Product Owners seeking to understand the Scrum Master role',
                    'Developers and team members in Agile environments',
                    'Agile Coaches and team leads',
                ],
                'what_you_will_learn' => [
                    'Master the Scrum framework, values, and accountabilities',
                    'Facilitate effective Scrum ceremonies and team interactions',
                    'Coach and develop self-organising, high-performing teams',
                    'Remove impediments and protect the team from distractions',
                    'Apply Scrum in real-world organisational contexts',
                    'Prepare for the PSM I (and PSM II) assessment',
                ],
                'course_curriculum' => [
                    'Scrum Theory and Values',
                    'The Scrum Team: Roles and Accountabilities',
                    'Scrum Events: Sprint, Planning, Review, Retrospective',
                    'Scrum Artifacts: Product Backlog, Sprint Backlog, Increment',
                    'The Scrum Master as a Servant Leader',
                    'Coaching and Facilitation Techniques',
                    'Scaling Scrum in Organisations',
                    'PSM Assessment Preparation',
                ],
                'what_you_get' => [
                    'PSM-aligned training materials',
                    'Practice assessments and mock questions',
                    'Facilitation guides and Scrum templates',
                    'Certificate of training completion',
                    'Exam preparation support',
                ],
                'why_train_with_us' => 'Facilitated by certified Scrum practitioners with real Agile transformation experience. Practical, scenario-based delivery.',
                'requirements' => [
                    'No formal prerequisites',
                    'Basic familiarity with Agile concepts is helpful',
                ],
                'tags' => ['Scrum', 'PSM', 'Agile', 'Scrum Master'],
            ],

            // ─── 7. Microsoft Project ─────────────────────────────────────────
            [
                'title'       => 'Microsoft Project Professional Training',
                'slug'        => 'microsoft-project-professional-training',
                'subtitle'    => 'Plan, Track, and Control Projects with Confidence',
                'description' => 'Our Microsoft Project Professional Training equips project managers, planners, and project control professionals with the hands-on skills to use MS Project effectively for real-world project delivery.

From creating schedules to tracking progress and generating management reports, this practical programme covers everything you need to manage projects with precision using Microsoft Project.',
                'category_id' => $pt?->id,
                'level'       => 'intermediate',
                'duration_hours' => 30,
                'duration_weeks' => 1,
                'schedule'    => 'Flexible — 3 to 5 days',
                'mode'        => 'Instructor-led (Virtual or Classroom)',
                'language'    => 'English',
                'price'       => 140000,
                'currency'    => 'NGN',
                'is_featured' => false,
                'who_course_is_for' => [
                    'Project Managers and Project Coordinators',
                    'Project Planners and Planning Engineers',
                    'Project Controls and PMO Professionals',
                    'Programme and Portfolio Managers',
                    'Anyone who manages projects and needs scheduling tools',
                ],
                'what_you_will_learn' => [
                    'Navigate the Microsoft Project interface confidently',
                    'Create detailed project plans with tasks, milestones, and dependencies',
                    'Assign resources and manage workloads',
                    'Develop schedules using the Critical Path Method (CPM)',
                    'Set baselines and track project progress',
                    'Generate and customise reports and dashboards',
                    'Control costs and performance using MS Project',
                ],
                'course_curriculum' => [
                    'Introduction to Microsoft Project Interface',
                    'Creating and Structuring a Project Plan',
                    'Task Entry, Linking, and Dependencies',
                    'Resource Assignment and Management',
                    'Schedule Development and Critical Path Analysis',
                    'Baseline Creation and Progress Tracking',
                    'Cost Control and Performance Reporting',
                    'Project Reporting and Dashboard Interpretation',
                ],
                'what_you_get' => [
                    'Practical, hands-on training using real project scenarios',
                    'Step-by-step guided exercises and case studies',
                    'Post-training support and learning materials',
                    'Industry-relevant templates and examples',
                ],
                'why_train_with_us' => 'Proven experience delivering project control training across multiple industries. Practical, industry-focused delivery by seasoned professionals.',
                'requirements' => [
                    'Basic project management knowledge is recommended',
                    'Access to Microsoft Project (desktop version) during training',
                ],
                'tags' => ['Microsoft Project', 'MS Project', 'Project Planning', 'Scheduling'],
            ],

            // ─── 8. Primavera P6 ─────────────────────────────────────────────
            [
                'title'       => 'Primavera P6 Professional Training',
                'slug'        => 'primavera-p6-professional-training',
                'subtitle'    => 'Advanced Project Planning, Scheduling & Control for Complex Projects',
                'description' => 'The Primavera P6 Professional training is designed for professionals responsible for managing complex, large-scale projects across engineering, construction, oil & gas, infrastructure, and industrial sectors.

This programme provides in-depth practical knowledge of Primavera P6, enabling participants to plan, schedule, monitor, and control large projects with accuracy and confidence.',
                'category_id' => $pt?->id,
                'level'       => 'advanced',
                'duration_hours' => 40,
                'duration_weeks' => 1,
                'schedule'    => 'Flexible — 3 to 5 days',
                'mode'        => 'Instructor-led (Virtual or Onsite)',
                'language'    => 'English',
                'price'       => 200000,
                'currency'    => 'NGN',
                'is_featured' => false,
                'who_course_is_for' => [
                    'Project Planners and Planning Engineers',
                    'Project Controls and Cost Engineers',
                    'Project Managers and Construction Managers',
                    'EPC and Infrastructure Project Professionals',
                    'Professionals involved in large-scale or multi-project environments',
                ],
                'what_you_will_learn' => [
                    'Build detailed project schedules using Primavera P6',
                    'Define work breakdown structures (WBS) and activity logic',
                    'Allocate resources and manage project costs',
                    'Create and manage baselines for performance tracking',
                    'Monitor progress and analyse schedule variance',
                    'Generate reports and dashboards for management decision-making',
                    'Manage multiple projects and portfolios effectively',
                ],
                'course_curriculum' => [
                    'Overview of Primavera P6 Interface',
                    'Creating and Managing Enterprise Project Structures (EPS)',
                    'Developing Work Breakdown Structures (WBS)',
                    'Activity Definition, Sequencing & Constraints',
                    'Resource and Cost Management',
                    'Schedule Analysis and Critical Path Method (CPM)',
                    'Updating Schedules and Progress Measurement',
                    'Reporting, Dashboards, and Project Controls',
                ],
                'what_you_get' => [
                    'Hands-on Primavera P6 training with real project examples',
                    'Templates, sample schedules, and reference materials',
                    'Instructor-led demonstrations and guided exercises',
                    'Post-training learning support',
                ],
                'why_train_with_us' => 'Delivered by experienced project control professionals. Proven track record across Oil & Gas, Infrastructure, Manufacturing, and Telecoms. Practical, industry-aligned training.',
                'requirements' => [
                    'Basic project management knowledge recommended',
                    'Familiarity with WBS and scheduling concepts is helpful',
                ],
                'tags' => ['Primavera P6', 'Oracle Primavera', 'Project Scheduling', 'EPC'],
            ],

            // ─── 9. PMI 60 PDU Renewal ────────────────────────────────────────
            [
                'title'       => 'PMI® 60 PDU Renewal Programme',
                'slug'        => 'pmi-60-pdu-renewal-programme',
                'subtitle'    => 'CCR Renewal Bundle – Maintain Your PMI Certification',
                'description' => 'The PMI® 60 PDU Renewal Programme is a comprehensive learning pathway designed to help certified Project Management Professionals (PMP®), PgMP®, PfMP®, PMI-ACP®, and PMI-RMP® holders earn the required 60 PDUs to renew their credentials.

This structured programme aligns fully with PMI\'s Continuing Certification Requirements (CCR) framework, covering all Talent Triangle™ areas: Ways of Working, Power Skills, and Business Acumen.',
                'category_id' => $pdu?->id,
                'level'       => 'intermediate',
                'duration_hours' => 60,
                'duration_weeks' => 8,
                'schedule'    => 'Flexible — self-paced with live instructor support',
                'mode'        => 'Live virtual sessions + on-demand content',
                'language'    => 'English',
                'price'       => 180000,
                'currency'    => 'NGN',
                'is_featured' => false,
                'who_course_is_for' => [
                    'PMP®, PgMP®, PMI-ACP®, PMI-RMP® and PfMP® credential holders',
                    'Project and Programme Managers seeking to maintain certification status',
                    'Professionals looking to upgrade skills while earning PDUs',
                    'Busy professionals who prefer flexible, structured learning',
                ],
                'what_you_will_learn' => [
                    'Earn 60 PMI-approved PDUs in line with PMI\'s CCR requirements',
                    'Strengthen leadership, strategic, and technical project management skills',
                    'Stay current with evolving best practices in project delivery',
                    'Improve professional credibility and career advancement potential',
                    'Maintain active PMI certification without exam retake',
                ],
                'course_curriculum' => [
                    'Agile, Hybrid & Predictive Project Delivery',
                    'Risk, Quality, and Schedule Management',
                    'Agile & Hybrid Governance',
                    'Leadership & Team Engagement',
                    'Stakeholder Communication',
                    'Conflict Resolution & Negotiation',
                    'Change Leadership',
                    'Strategic Alignment & Value Delivery',
                    'Benefits Realisation & Portfolio Thinking',
                    'Financial Acumen for Project Managers',
                ],
                'what_you_get' => [
                    'Official PMI-aligned PDU certificates (60 PDUs total)',
                    'Structured learning path mapped to PMI Talent Triangle',
                    'Real-world case studies and applied learning',
                    'Instructor-led sessions with experienced PMP-certified trainers',
                    'Post-training guidance for PMI CCR reporting',
                ],
                'why_train_with_us' => 'Trusted PMI training partner with years of delivery experience. Facilitators with real-world programme and portfolio leadership backgrounds. Practical, application-focused learning.',
                'requirements' => [
                    'Active PMP®, PgMP®, PMI-ACP®, PMI-RMP® or PfMP® certification',
                    'Access to PMI\'s online CCR portal for PDU submission',
                ],
                'tags' => ['PDU', 'PMI', 'CPD', 'PMP Renewal', 'CCR'],
            ],

        ];

        foreach ($courses as $data) {
            Course::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'instructor_id' => $instructor->id,
                    'status'        => 'published',
                    'is_published'  => true,
                    'published_at'  => now(),
                ])
            );
        }

        $this->command->info('✅ ' . count($courses) . ' courses seeded successfully.');
    }
}