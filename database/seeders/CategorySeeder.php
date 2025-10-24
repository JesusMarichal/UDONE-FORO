<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Anuncios Generales',
                'slug' => 'anuncios-generales',
                'description' => 'Anuncios oficiales de la universidad y noticias importantes.',
                'color' => '#dc3545',
                'icon' => 'fas fa-bullhorn',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Ayuda Académica',
                'slug' => 'ayuda-academica',
                'description' => 'Solicita y ofrece ayuda con materias, tareas y proyectos.',
                'color' => '#0d6efd',
                'icon' => 'fas fa-book',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Programación',
                'slug' => 'programacion',
                'description' => 'Discusiones sobre lenguajes de programación, algoritmos y desarrollo de software.',
                'color' => '#198754',
                'icon' => 'fas fa-code',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Matemáticas',
                'slug' => 'matematicas',
                'description' => 'Ayuda con cálculo, álgebra, estadística y más.',
                'color' => '#fd7e14',
                'icon' => 'fas fa-calculator',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Vida Universitaria',
                'slug' => 'vida-universitaria',
                'description' => 'Comparte experiencias, eventos y actividades del campus.',
                'color' => '#6f42c1',
                'icon' => 'fas fa-users',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Recursos y Materiales',
                'slug' => 'recursos-materiales',
                'description' => 'Comparte y solicita apuntes, libros, presentaciones y otros recursos.',
                'color' => '#20c997',
                'icon' => 'fas fa-folder-open',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Carreras y Profesiones',
                'slug' => 'carreras-profesiones',
                'description' => 'Discute sobre diferentes carreras, oportunidades laborales y orientación profesional.',
                'color' => '#0dcaf0',
                'icon' => 'fas fa-briefcase',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Sugerencias y Comentarios',
                'slug' => 'sugerencias-comentarios',
                'description' => 'Comparte tus ideas para mejorar el foro y la experiencia universitaria.',
                'color' => '#6c757d',
                'icon' => 'fas fa-lightbulb',
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
