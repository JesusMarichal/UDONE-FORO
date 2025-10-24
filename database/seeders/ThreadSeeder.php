<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();

        // Sample threads
        $threads = [
            [
                'category' => 'anuncios-generales',
                'user_email' => 'admin@udone.edu.ve',
                'title' => 'Bienvenidos al Foro UDONE',
                'body' => "¡Bienvenidos al foro oficial de la Universidad de Oriente Núcleo Nueva Esparta!\n\nEste es un espacio para compartir conocimientos, resolver dudas y conectar con otros estudiantes.\n\nPor favor, mantengamos un ambiente respetuoso y colaborativo.",
                'is_pinned' => true,
                'view_count' => 150,
            ],
            [
                'category' => 'ayuda-academica',
                'user_email' => 'maria@udone.edu.ve',
                'title' => '¿Alguien tiene apuntes de Álgebra Lineal?',
                'body' => "Hola a todos,\n\nEstoy buscando apuntes o material de estudio para Álgebra Lineal, específicamente sobre espacios vectoriales y transformaciones lineales.\n\n¿Alguien podría compartir recursos o recomendar algún libro?",
                'view_count' => 45,
            ],
            [
                'category' => 'programacion',
                'user_email' => 'maria@udone.edu.ve',
                'title' => 'Duda sobre recursividad en Python',
                'body' => "Estoy teniendo problemas para entender cómo funciona la recursividad en Python.\n\n¿Alguien podría explicarme con un ejemplo simple cómo se implementa la función factorial recursiva?",
                'view_count' => 78,
            ],
            [
                'category' => 'matematicas',
                'user_email' => 'carlos@udone.edu.ve',
                'title' => 'Ayuda con límites al infinito',
                'body' => "Necesito ayuda para resolver límites cuando x tiende a infinito.\n\n¿Tienen algún truco o método que facilite este tipo de ejercicios?",
                'view_count' => 32,
            ],
            [
                'category' => 'vida-universitaria',
                'user_email' => 'ana@udone.edu.ve',
                'title' => 'Actividades deportivas en el campus',
                'body' => "¿Alguien sabe si hay equipos deportivos o actividades recreativas en el campus?\n\nMe gustaría unirme a algún grupo para hacer ejercicio y conocer más personas.",
                'view_count' => 56,
            ],
            [
                'category' => 'recursos-materiales',
                'user_email' => 'maria@udone.edu.ve',
                'title' => 'Libros recomendados para Estructura de Datos',
                'body' => "¿Qué libros me recomiendan para estudiar Estructura de Datos?\n\nEstoy buscando material que sea claro y tenga buenos ejemplos prácticos.",
                'view_count' => 41,
            ],
        ];

        foreach ($threads as $threadData) {
            $category = Category::where('slug', $threadData['category'])->first();
            $user = User::where('email', $threadData['user_email'])->first();

            $thread = Thread::create([
                'category_id' => $category->id,
                'user_id' => $user->id,
                'title' => $threadData['title'],
                'slug' => \Illuminate\Support\Str::slug($threadData['title']),
                'body' => $threadData['body'],
                'is_pinned' => $threadData['is_pinned'] ?? false,
                'is_locked' => false,
                'view_count' => $threadData['view_count'],
            ]);

            // Add some sample posts to threads
            if ($thread->id > 1) {
                $randomUsers = $users->random(rand(1, 3));
                foreach ($randomUsers as $randomUser) {
                    Post::create([
                        'thread_id' => $thread->id,
                        'user_id' => $randomUser->id,
                        'body' => $this->getRandomReply(),
                        'is_solution' => false,
                    ]);
                }
            }
        }
    }

    private function getRandomReply(): string
    {
        $replies = [
            "Gracias por compartir esta información. Me parece muy útil.",
            "Yo también tengo la misma duda. Espero que alguien pueda ayudarnos.",
            "He encontrado algunos recursos que podrían ser útiles. Los compartiré pronto.",
            "Excelente pregunta. Déjame investigar un poco y te respondo.",
            "Creo que puedo ayudarte con esto. Te envío la información por aquí.",
        ];

        return $replies[array_rand($replies)];
    }
}
