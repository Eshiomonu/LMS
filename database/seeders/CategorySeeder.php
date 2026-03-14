<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Project Management',
                'description' => 'Professional certification and skills training for project managers.',
            ],
            [
                'name'        => 'Business Analysis',
                'description' => 'Certification and practical training for business analysts.',
            ],
            [
                'name'        => 'IT Service Management',
                'description' => 'ITIL and IT service management frameworks and certifications.',
            ],
            [
                'name'        => 'Agile & Scrum',
                'description' => 'Agile methodologies, Scrum, and hybrid delivery frameworks.',
            ],
            [
                'name'        => 'Data & Analytics',
                'description' => 'Data analysis, visualisation, and business intelligence training.',
            ],
            [
                'name'        => 'Project Planning Tools',
                'description' => 'Hands-on training in Microsoft Project, Primavera P6, and planning tools.',
            ],
            [
                'name'        => 'PDU & CPD Programmes',
                'description' => 'Structured programmes for maintaining professional certifications.',
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name'        => $cat['name'],
                    'slug'        => Str::slug($cat['name']),
                    'description' => $cat['description'],
                    'is_active'   => true,
                ]
            );
        }
    }
}