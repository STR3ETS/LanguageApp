<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            [
                'name' => 'Dutch',
                'slug' => 'dutch',
                'native_name' => 'Nederlands',
                'flag_emoji' => "\u{1F1F3}\u{1F1F1}",
                'flag_code' => 'nl',
                'description' => 'The language of the Netherlands and Belgium. Open the door to Dutch culture and business.',
                'price_monthly' => 8.99,
                'sort_order' => 1,
            ],
            [
                'name' => 'German',
                'slug' => 'german',
                'native_name' => 'Deutsch',
                'flag_emoji' => "\u{1F1E9}\u{1F1EA}",
                'flag_code' => 'de',
                'description' => "Europe's most spoken native language. Key to business, engineering and culture.",
                'price_monthly' => 8.99,
                'sort_order' => 2,
            ],
            [
                'name' => 'French',
                'slug' => 'french',
                'native_name' => "Fran\u{00E7}ais",
                'flag_emoji' => "\u{1F1EB}\u{1F1F7}",
                'flag_code' => 'fr',
                'description' => 'The language of culture, cuisine and diplomacy. Spoken across five continents.',
                'price_monthly' => 8.99,
                'sort_order' => 3,
            ],
            [
                'name' => 'Spanish',
                'slug' => 'spanish',
                'native_name' => "Espa\u{00F1}ol",
                'flag_emoji' => "\u{1F1EA}\u{1F1F8}",
                'flag_code' => 'es',
                'description' => 'The most popular language to learn. Spoken by over 500 million people worldwide.',
                'price_monthly' => 8.99,
                'sort_order' => 4,
            ],
            [
                'name' => 'Portuguese',
                'slug' => 'portuguese',
                'native_name' => "Portugu\u{00EA}s",
                'flag_emoji' => "\u{1F1F5}\u{1F1F9}",
                'flag_code' => 'pt',
                'description' => "From Lisbon to S\u{00E3}o Paulo. A global language with a warm rhythm.",
                'price_monthly' => 8.99,
                'sort_order' => 5,
            ],
            [
                'name' => 'Italian',
                'slug' => 'italian',
                'native_name' => 'Italiano',
                'flag_emoji' => "\u{1F1EE}\u{1F1F9}",
                'flag_code' => 'it',
                'description' => 'The language of art, music and la dolce vita. Beautiful and expressive.',
                'price_monthly' => 8.99,
                'sort_order' => 6,
            ],
            [
                'name' => 'Turkish',
                'slug' => 'turkish',
                'native_name' => "T\u{00FC}rk\u{00E7}e",
                'flag_emoji' => "\u{1F1F9}\u{1F1F7}",
                'flag_code' => 'tr',
                'description' => 'Bridge between Europe and Asia. A fascinating language with a rich history.',
                'price_monthly' => 8.99,
                'sort_order' => 7,
            ],
            [
                'name' => 'Russian',
                'slug' => 'russian',
                'native_name' => "\u{0420}\u{0443}\u{0441}\u{0441}\u{043A}\u{0438}\u{0439}",
                'flag_emoji' => "\u{1F1F7}\u{1F1FA}",
                'flag_code' => 'ru',
                'description' => 'Spoken by 250 million people. Unlock Russian literature, science and culture.',
                'price_monthly' => 8.99,
                'sort_order' => 8,
            ],
            [
                'name' => 'Japanese',
                'slug' => 'japanese',
                'native_name' => "\u{65E5}\u{672C}\u{8A9E}",
                'flag_emoji' => "\u{1F1EF}\u{1F1F5}",
                'flag_code' => 'jp',
                'description' => 'Discover a rich culture through its language. From anime to business.',
                'price_monthly' => 8.99,
                'sort_order' => 10,
            ],
            [
                'name' => 'Chinese',
                'slug' => 'chinese',
                'native_name' => "\u{4E2D}\u{6587}",
                'flag_emoji' => "\u{1F1E8}\u{1F1F3}",
                'flag_code' => 'cn',
                'description' => 'The most spoken language on earth. Essential for global business and travel.',
                'price_monthly' => 8.99,
                'sort_order' => 11,
            ],
        ];

        foreach ($languages as $langData) {
            $language = Language::create($langData);
            $this->seedCurriculum($language);
        }
    }

    private function seedCurriculum(Language $language): void
    {
        $curriculum = $this->getCurriculum();
        $xpCumulative = 0;

        foreach ($curriculum as $levelIndex => $level) {
            $dbLevel = $language->levels()->create([
                'number' => $levelIndex + 1,
                'name' => $level['name'],
                'description' => $level['description'],
                'cefr' => $level['cefr'] ?? 'A1',
                'xp_required' => $xpCumulative,
                'sort_order' => $levelIndex,
            ]);

            foreach ($level['lessons'] as $lessonIndex => $lesson) {
                $dbLevel->lessons()->create([
                    'title' => $lesson['title'],
                    'description' => $lesson['description'] ?? null,
                    'type' => $lesson['type'],
                    'xp_reward' => $lesson['xp'],
                    'sort_order' => $lessonIndex,
                ]);
                $xpCumulative += $lesson['xp'];
            }
        }
    }

    private function getCurriculum(): array
    {
        return [
            // ═══ MODULE 1: FOUNDATIONS (A1.1) ═══
            [
                'name' => 'Hello World',
                'cefr' => 'A1',
                'description' => 'Greetings, introductions and making a first impression.',
                'lessons' => [
                    ['title' => 'Greetings', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Say hello and goodbye.'],
                    ['title' => 'Introductions', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Introduce yourself.'],
                    ['title' => 'Yes and no', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Basic agreement and disagreement.'],
                    ['title' => 'Basic phrases', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Essential everyday phrases.'],
                ],
            ],
            [
                'name' => 'Counting',
                'cefr' => 'A1',
                'description' => 'Learn to count and use numbers.',
                'lessons' => [
                    ['title' => 'Numbers 1-10', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Count from one to ten.'],
                    ['title' => 'Numbers 11-20', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Count to twenty.'],
                    ['title' => 'The alphabet', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Letters and spelling.'],
                ],
            ],

            // ═══ MODULE 2: PEOPLE & DESCRIPTIONS (A1.2) ═══
            [
                'name' => 'Family',
                'cefr' => 'A1',
                'description' => 'Talk about your family and relationships.',
                'lessons' => [
                    ['title' => 'Family members', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Parents, siblings and children.'],
                    ['title' => 'More family', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Extended family members.'],
                    ['title' => 'Describing people', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Describe appearance and character.'],
                ],
            ],
            [
                'name' => 'Colors & Shapes',
                'cefr' => 'A1',
                'description' => 'Describe the world around you with colors.',
                'lessons' => [
                    ['title' => 'Colors', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Basic colors.'],
                    ['title' => 'More colors', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Extended color palette.'],
                    ['title' => 'Adjectives', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Big, small, good, bad.'],
                    ['title' => 'More adjectives', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Fast, slow, easy, difficult.'],
                ],
            ],

            // ═══ MODULE 3: DAILY LIFE (A1.3) ═══
            [
                'name' => 'Food & Drink',
                'cefr' => 'A1',
                'description' => 'Order food and talk about meals.',
                'lessons' => [
                    ['title' => 'Food basics', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Essential food items.'],
                    ['title' => 'More food', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Meat, fish, eggs and more.'],
                    ['title' => 'Fruits', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Common fruits.'],
                    ['title' => 'Drinks', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Beverages and refreshments.'],
                    ['title' => 'Meals', 'type' => 'conversation', 'xp' => 15, 'description' => 'Breakfast, lunch and dinner.'],
                ],
            ],
            [
                'name' => 'Eating Out',
                'cefr' => 'A1',
                'description' => 'Navigate restaurants and cafes.',
                'lessons' => [
                    ['title' => 'At the restaurant', 'type' => 'conversation', 'xp' => 15, 'description' => 'Order like a local.'],
                ],
            ],

            // ═══ MODULE 4: HOME & ROUTINE (A2.1) ═══
            [
                'name' => 'At Home',
                'cefr' => 'A2',
                'description' => 'Talk about your home and daily life.',
                'lessons' => [
                    ['title' => 'The house', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Rooms in the house.'],
                    ['title' => 'Furniture', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Common furniture items.'],
                    ['title' => 'Daily routine', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Wake up, work, sleep.'],
                ],
            ],
            [
                'name' => 'Time & Calendar',
                'cefr' => 'A2',
                'description' => 'Tell time and talk about schedules.',
                'lessons' => [
                    ['title' => 'Telling time', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'What time is it?'],
                    ['title' => 'Days of the week', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Monday through Sunday.'],
                    ['title' => 'Months', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'January through December.'],
                ],
            ],

            // ═══ MODULE 5: GETTING AROUND (A2.2) ═══
            [
                'name' => 'Weather & Seasons',
                'cefr' => 'A2',
                'description' => 'Talk about the weather and seasons.',
                'lessons' => [
                    ['title' => 'Weather', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Sun, rain, wind and snow.'],
                    ['title' => 'Seasons', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Spring, summer, autumn, winter.'],
                ],
            ],
            [
                'name' => 'Navigation',
                'cefr' => 'A2',
                'description' => 'Ask for directions and find your way.',
                'lessons' => [
                    ['title' => 'Directions', 'type' => 'conversation', 'xp' => 15, 'description' => 'Left, right, straight ahead.'],
                    ['title' => 'Places in town', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Streets, shops, parks.'],
                ],
            ],
            [
                'name' => 'Transport',
                'cefr' => 'A2',
                'description' => 'Get around by car, bus, train and plane.',
                'lessons' => [
                    ['title' => 'Transport', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Vehicles and transport.'],
                    ['title' => 'At the station', 'type' => 'conversation', 'xp' => 15, 'description' => 'Buy tickets and check schedules.'],
                ],
            ],
            [
                'name' => 'Shopping',
                'cefr' => 'A2',
                'description' => 'Buy things and talk about prices.',
                'lessons' => [
                    ['title' => 'Shopping basics', 'type' => 'conversation', 'xp' => 15, 'description' => 'Buy, sell, price.'],
                    ['title' => 'Clothing', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Shirts, pants, shoes.'],
                ],
            ],

            // ═══ MODULE 6: BODY & HEALTH (B1.1) ═══
            [
                'name' => 'The Body',
                'cefr' => 'B1',
                'description' => 'Learn body parts and talk about health.',
                'lessons' => [
                    ['title' => 'Body parts', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Head, hands, feet.'],
                    ['title' => 'More body parts', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Arms, legs, back.'],
                    ['title' => 'At the doctor', 'type' => 'conversation', 'xp' => 15, 'description' => 'Describe symptoms.'],
                ],
            ],
            [
                'name' => 'Feelings',
                'cefr' => 'B1',
                'description' => 'Express your emotions and mood.',
                'lessons' => [
                    ['title' => 'Feelings', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Happy, sad, tired, angry.'],
                    ['title' => 'Emotions', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Love, fear, joy, surprise.'],
                ],
            ],

            // ═══ MODULE 7: HOBBIES & SOCIAL (B1.2) ═══
            [
                'name' => 'Free Time',
                'cefr' => 'B1',
                'description' => 'Talk about hobbies and activities.',
                'lessons' => [
                    ['title' => 'Hobbies', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Read, cook, dance, swim.'],
                    ['title' => 'Sports', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Football, tennis, running.'],
                    ['title' => 'Music and art', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Music, movies, books.'],
                ],
            ],
            [
                'name' => 'Social Life',
                'cefr' => 'B1',
                'description' => 'Make plans and hang out.',
                'lessons' => [
                    ['title' => 'Making plans', 'type' => 'conversation', 'xp' => 15, 'description' => 'Invite friends and make plans.'],
                    ['title' => 'Technology', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Phone, internet, messages.'],
                    ['title' => 'Opinions', 'type' => 'conversation', 'xp' => 15, 'description' => 'Express likes and preferences.'],
                    ['title' => 'Conversation phrases', 'type' => 'conversation', 'xp' => 15, 'description' => 'Sound natural in conversation.'],
                ],
            ],

            // ═══ MODULE 8: TRAVEL (B1.3) ═══
            [
                'name' => 'At the Airport',
                'cefr' => 'B1',
                'description' => 'Navigate airports and flights.',
                'lessons' => [
                    ['title' => 'At the airport', 'type' => 'conversation', 'xp' => 15, 'description' => 'Flights, boarding, luggage.'],
                    ['title' => 'Booking', 'type' => 'conversation', 'xp' => 15, 'description' => 'Reserve, cancel, confirm.'],
                ],
            ],
            [
                'name' => 'Accommodation',
                'cefr' => 'B1',
                'description' => 'Book and navigate hotels.',
                'lessons' => [
                    ['title' => 'At the hotel', 'type' => 'conversation', 'xp' => 15, 'description' => 'Check in and ask for help.'],
                    ['title' => 'Sightseeing', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Museums, beaches, mountains.'],
                    ['title' => 'Emergencies', 'type' => 'conversation', 'xp' => 15, 'description' => 'Get help in urgent situations.'],
                ],
            ],

            // ═══ MODULE 9: NATURE & WORLD (B1.4) ═══
            [
                'name' => 'Nature',
                'cefr' => 'B1',
                'description' => 'Talk about nature, animals and the environment.',
                'lessons' => [
                    ['title' => 'Nature', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Trees, flowers, rivers, sky.'],
                    ['title' => 'Animals', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Dogs, cats, birds and more.'],
                ],
            ],

            // ═══ MODULE 10: WORK & STUDY (B1.5) ═══
            [
                'name' => 'Education',
                'cefr' => 'B1',
                'description' => 'Talk about school and learning.',
                'lessons' => [
                    ['title' => 'At school', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Teachers, students, exams.'],
                    ['title' => 'Professions', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Doctor, lawyer, engineer.'],
                    ['title' => 'At the office', 'type' => 'conversation', 'xp' => 15, 'description' => 'Meetings, emails, deadlines.'],
                ],
            ],

            // ═══ MODULE 11: GRAMMAR POWER (B1.6) ═══
            [
                'name' => 'Essential Verbs 1',
                'cefr' => 'B1',
                'description' => 'Master the most common verbs.',
                'lessons' => [
                    ['title' => 'Common verbs 1', 'type' => 'grammar', 'xp' => 15, 'description' => 'To be, to have, to go.'],
                    ['title' => 'Common verbs 2', 'type' => 'grammar', 'xp' => 15, 'description' => 'To want, to know, to speak.'],
                    ['title' => 'Common verbs 3', 'type' => 'grammar', 'xp' => 15, 'description' => 'To give, to think, to believe.'],
                ],
            ],
            [
                'name' => 'Tenses',
                'cefr' => 'B1',
                'description' => 'Talk about past, present and future.',
                'lessons' => [
                    ['title' => 'Past tense basics', 'type' => 'grammar', 'xp' => 20, 'description' => 'Talk about what happened.'],
                    ['title' => 'Future tense', 'type' => 'grammar', 'xp' => 20, 'description' => 'Talk about what will happen.'],
                ],
            ],

            // ═══ B2: UPPER INTERMEDIATE ═══

            [
                'name' => 'Work & Career',
                'cefr' => 'B2',
                'description' => 'Professional language for the workplace.',
                'lessons' => [
                    ['title' => 'Job interviews', 'type' => 'conversation', 'xp' => 15, 'description' => 'Answer common interview questions.'],
                    ['title' => 'The workplace', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Colleagues, deadlines, projects.'],
                    ['title' => 'Writing emails', 'type' => 'grammar', 'xp' => 15, 'description' => 'Formal and informal emails.'],
                    ['title' => 'Presentations', 'type' => 'conversation', 'xp' => 15, 'description' => 'Present ideas clearly.'],
                ],
            ],
            [
                'name' => 'Media & News',
                'cefr' => 'B2',
                'description' => 'Understand news articles and media.',
                'lessons' => [
                    ['title' => 'Reading the news', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Headlines, articles, opinions.'],
                    ['title' => 'Politics', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Government, elections, policy.'],
                    ['title' => 'Economy', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Money, markets, trade.'],
                ],
            ],
            [
                'name' => 'Relationships',
                'cefr' => 'B2',
                'description' => 'Talk about complex relationships and feelings.',
                'lessons' => [
                    ['title' => 'Describing personality', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Ambitious, generous, stubborn.'],
                    ['title' => 'Conflict and resolution', 'type' => 'conversation', 'xp' => 15, 'description' => 'Disagree politely and find solutions.'],
                    ['title' => 'Life events', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Marriage, moving, milestones.'],
                ],
            ],
            [
                'name' => 'Health & Wellness',
                'cefr' => 'B2',
                'description' => 'Discuss health topics in depth.',
                'lessons' => [
                    ['title' => 'Mental health', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Stress, anxiety, balance.'],
                    ['title' => 'Fitness & diet', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Exercise, nutrition, lifestyle.'],
                    ['title' => 'Medical conversations', 'type' => 'conversation', 'xp' => 15, 'description' => 'Explain symptoms in detail.'],
                ],
            ],
            [
                'name' => 'Advanced Grammar 1',
                'cefr' => 'B2',
                'description' => 'Complex sentence structures.',
                'lessons' => [
                    ['title' => 'Conditional sentences', 'type' => 'grammar', 'xp' => 20, 'description' => 'If I were you, I would...'],
                    ['title' => 'Passive voice', 'type' => 'grammar', 'xp' => 20, 'description' => 'The book was written by...'],
                    ['title' => 'Reported speech', 'type' => 'grammar', 'xp' => 20, 'description' => 'She said that she was...'],
                ],
            ],
            [
                'name' => 'Culture & Society',
                'cefr' => 'B2',
                'description' => 'Discuss cultural topics and traditions.',
                'lessons' => [
                    ['title' => 'Traditions', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Festivals, holidays, customs.'],
                    ['title' => 'Art & literature', 'type' => 'vocabulary', 'xp' => 10, 'description' => 'Books, paintings, music.'],
                    ['title' => 'Debating', 'type' => 'conversation', 'xp' => 15, 'description' => 'Argue your point persuasively.'],
                ],
            ],

            // ═══ C1: ADVANCED ═══

            [
                'name' => 'Abstract Thinking',
                'cefr' => 'C1',
                'description' => 'Express complex and abstract ideas.',
                'lessons' => [
                    ['title' => 'Philosophy', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Truth, existence, meaning.'],
                    ['title' => 'Hypotheticals', 'type' => 'grammar', 'xp' => 20, 'description' => 'What if scenarios and speculation.'],
                    ['title' => 'Nuanced opinions', 'type' => 'conversation', 'xp' => 15, 'description' => 'Express subtle differences in meaning.'],
                ],
            ],
            [
                'name' => 'Academic Language',
                'cefr' => 'C1',
                'description' => 'Language for academic and research contexts.',
                'lessons' => [
                    ['title' => 'Academic vocabulary', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Research, analysis, methodology.'],
                    ['title' => 'Writing essays', 'type' => 'grammar', 'xp' => 20, 'description' => 'Structure arguments logically.'],
                    ['title' => 'Citing and referencing', 'type' => 'grammar', 'xp' => 15, 'description' => 'According to, based on, as stated by.'],
                ],
            ],
            [
                'name' => 'Business Advanced',
                'cefr' => 'C1',
                'description' => 'High-level professional communication.',
                'lessons' => [
                    ['title' => 'Negotiations', 'type' => 'conversation', 'xp' => 20, 'description' => 'Reach agreements and compromises.'],
                    ['title' => 'Legal language', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Contracts, terms, regulations.'],
                    ['title' => 'Financial reports', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Revenue, profit, investment.'],
                ],
            ],
            [
                'name' => 'Idiomatic Expressions',
                'cefr' => 'C1',
                'description' => 'Sound natural with idioms and expressions.',
                'lessons' => [
                    ['title' => 'Common idioms', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Break the ice, piece of cake.'],
                    ['title' => 'Slang and colloquial', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Informal everyday language.'],
                    ['title' => 'Proverbs and sayings', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Traditional wisdom in language.'],
                ],
            ],
            [
                'name' => 'Advanced Grammar 2',
                'cefr' => 'C1',
                'description' => 'Master the most complex structures.',
                'lessons' => [
                    ['title' => 'Subjunctive mood', 'type' => 'grammar', 'xp' => 20, 'description' => 'Wishes, doubts, and demands.'],
                    ['title' => 'Complex connectors', 'type' => 'grammar', 'xp' => 20, 'description' => 'Nevertheless, whereas, albeit.'],
                    ['title' => 'Inversion and emphasis', 'type' => 'grammar', 'xp' => 20, 'description' => 'Not only did he... but also...'],
                ],
            ],

            // ═══ C2: MASTERY ═══

            [
                'name' => 'Literary Language',
                'cefr' => 'C2',
                'description' => 'Appreciate and discuss literature.',
                'lessons' => [
                    ['title' => 'Literary analysis', 'type' => 'vocabulary', 'xp' => 20, 'description' => 'Metaphor, irony, symbolism.'],
                    ['title' => 'Poetry and prose', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Rhythm, tone, narrative voice.'],
                    ['title' => 'Critical writing', 'type' => 'grammar', 'xp' => 20, 'description' => 'Write reviews and critiques.'],
                ],
            ],
            [
                'name' => 'Rhetoric & Persuasion',
                'cefr' => 'C2',
                'description' => 'Master the art of persuasive communication.',
                'lessons' => [
                    ['title' => 'Rhetorical devices', 'type' => 'vocabulary', 'xp' => 20, 'description' => 'Analogy, repetition, contrast.'],
                    ['title' => 'Public speaking', 'type' => 'conversation', 'xp' => 20, 'description' => 'Deliver compelling speeches.'],
                    ['title' => 'Persuasive writing', 'type' => 'grammar', 'xp' => 20, 'description' => 'Convince through written argument.'],
                ],
            ],
            [
                'name' => 'Specialized Vocabulary',
                'cefr' => 'C2',
                'description' => 'Domain-specific language mastery.',
                'lessons' => [
                    ['title' => 'Science & technology', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Innovation, algorithms, research.'],
                    ['title' => 'Law & governance', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Legislation, rights, democracy.'],
                    ['title' => 'Medicine', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Diagnosis, treatment, prognosis.'],
                    ['title' => 'Environment', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Climate, sustainability, ecology.'],
                ],
            ],
            [
                'name' => 'Native-Level Expression',
                'cefr' => 'C2',
                'description' => 'Express yourself with native-level fluency.',
                'lessons' => [
                    ['title' => 'Humor and sarcasm', 'type' => 'conversation', 'xp' => 20, 'description' => 'Understand and use wit.'],
                    ['title' => 'Regional variations', 'type' => 'vocabulary', 'xp' => 15, 'description' => 'Dialects and regional expressions.'],
                    ['title' => 'Improvisation', 'type' => 'conversation', 'xp' => 20, 'description' => 'Think on your feet in any situation.'],
                    ['title' => 'Mastery review', 'type' => 'conversation', 'xp' => 25, 'description' => 'Prove your fluency across all topics.'],
                ],
            ],
        ];
    }
}
