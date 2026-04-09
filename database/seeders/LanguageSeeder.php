<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            ['name' => 'Dutch', 'slug' => 'dutch', 'native_name' => 'Nederlands', 'flag_emoji' => "\u{1F1F3}\u{1F1F1}", 'flag_code' => 'nl', 'description' => 'The language of the Netherlands and Belgium. Open the door to Dutch culture and business.', 'price_monthly' => 8.99, 'sort_order' => 1],
            ['name' => 'Turkish', 'slug' => 'turkish', 'native_name' => "T\u{00FC}rk\u{00E7}e", 'flag_emoji' => "\u{1F1F9}\u{1F1F7}", 'flag_code' => 'tr', 'description' => 'Bridge between Europe and Asia. A fascinating language with a rich history.', 'price_monthly' => 8.99, 'sort_order' => 2],
        ];

        foreach ($languages as $langData) {
            $language = Language::create($langData);
            $this->seedCurriculum($language);
        }
    }

    private function seedCurriculum(Language $language): void
    {
        $fullCurriculum = $this->getCurriculum();

        // Per-language curriculum
        $curriculum = match($language->slug) {
            'turkish' => array_merge($this->getTurkishA1(), $this->getTurkishA2()),
            'dutch' => [],
            default => $fullCurriculum,
        };

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

    private function getTurkishA1(): array
    {
        return [
            ['name'=>'Greetings','cefr'=>'A1','description'=>'Say hello, goodbye and introduce yourself.','lessons'=>[
                ['title'=>'TR A1 Greetings 1','type'=>'vocabulary','xp'=>10,'description'=>'Basic hello and goodbye.'],
                ['title'=>'TR A1 Greetings 2','type'=>'vocabulary','xp'=>10,'description'=>'Time-based greetings.'],
                ['title'=>'TR A1 Introductions 1','type'=>'vocabulary','xp'=>10,'description'=>'Introduce yourself.'],
                ['title'=>'TR A1 Introductions 2','type'=>'conversation','xp'=>10,'description'=>'Ask about others.'],
                ['title'=>'TR A1 Polite 1','type'=>'vocabulary','xp'=>15,'description'=>'Please, thank you, sorry.'],
                ['title'=>'TR A1 Polite 2','type'=>'conversation','xp'=>15,'description'=>'Formal politeness.'],
            ]],
            ['name'=>'Numbers','cefr'=>'A1','description'=>'Count, tell your age, use numbers daily.','lessons'=>[
                ['title'=>'TR A1 Singles','type'=>'vocabulary','xp'=>10,'description'=>'Numbers one to ten.'],
                ['title'=>'TR A1 Tens','type'=>'vocabulary','xp'=>10,'description'=>'Ten, twenty, thirty to hundred.'],
                ['title'=>'TR A1 Hundreds','type'=>'vocabulary','xp'=>10,'description'=>'Hundreds and thousands.'],
                ['title'=>'TR A1 Ordinals','type'=>'vocabulary','xp'=>10,'description'=>'First, second, third.'],
                ['title'=>'TR A1 Age and counting','type'=>'conversation','xp'=>15,'description'=>'How old are you?'],
            ]],
            ['name'=>'Family & People','cefr'=>'A1','description'=>'Talk about family and describe people.','lessons'=>[
                ['title'=>'TR A1 Family 1','type'=>'vocabulary','xp'=>10,'description'=>'Close family members.'],
                ['title'=>'TR A1 Family 2','type'=>'vocabulary','xp'=>10,'description'=>'Extended family.'],
                ['title'=>'TR A1 Appearance','type'=>'vocabulary','xp'=>10,'description'=>'Describe how people look.'],
                ['title'=>'TR A1 Personality','type'=>'vocabulary','xp'=>10,'description'=>'Basic character traits.'],
                ['title'=>'TR A1 Nationalities','type'=>'vocabulary','xp'=>10,'description'=>'Countries and nationalities.'],
                ['title'=>'TR A1 My family','type'=>'conversation','xp'=>15,'description'=>'Talk about your family.'],
            ]],
            ['name'=>'Colors & Adjectives','cefr'=>'A1','description'=>'Describe objects and the world around you.','lessons'=>[
                ['title'=>'TR A1 Colors','type'=>'vocabulary','xp'=>10,'description'=>'Basic colors.'],
                ['title'=>'TR A1 More colors','type'=>'vocabulary','xp'=>10,'description'=>'More colors and shades.'],
                ['title'=>'TR A1 Adjectives 1','type'=>'vocabulary','xp'=>10,'description'=>'Size and quality.'],
                ['title'=>'TR A1 Adjectives 2','type'=>'vocabulary','xp'=>10,'description'=>'Speed, temperature, difficulty.'],
                ['title'=>'TR A1 Opposites','type'=>'vocabulary','xp'=>15,'description'=>'Hot/cold, big/small.'],
            ]],
            ['name'=>'Food & Drink','cefr'=>'A1','description'=>'Order food, name ingredients, eat out.','lessons'=>[
                ['title'=>'TR A1 Food 1','type'=>'vocabulary','xp'=>10,'description'=>'Bread, rice, meat, eggs.'],
                ['title'=>'TR A1 Food 2','type'=>'vocabulary','xp'=>10,'description'=>'Vegetables and sides.'],
                ['title'=>'TR A1 Fruits','type'=>'vocabulary','xp'=>10,'description'=>'Common fruits.'],
                ['title'=>'TR A1 Drinks','type'=>'vocabulary','xp'=>10,'description'=>'Water, tea, coffee, juice.'],
                ['title'=>'TR A1 Meals','type'=>'vocabulary','xp'=>10,'description'=>'Breakfast, lunch, dinner.'],
                ['title'=>'TR A1 Restaurant','type'=>'conversation','xp'=>15,'description'=>'Order at a restaurant.'],
            ]],
            ['name'=>'Daily Life','cefr'=>'A1','description'=>'Routine, time, days and months.','lessons'=>[
                ['title'=>'TR A1 Routine 1','type'=>'vocabulary','xp'=>10,'description'=>'Morning routine verbs.'],
                ['title'=>'TR A1 Routine 2','type'=>'vocabulary','xp'=>10,'description'=>'Evening routine verbs.'],
                ['title'=>'TR A1 Days','type'=>'vocabulary','xp'=>10,'description'=>'Days of the week.'],
                ['title'=>'TR A1 Months','type'=>'vocabulary','xp'=>10,'description'=>'Months of the year.'],
                ['title'=>'TR A1 Time','type'=>'vocabulary','xp'=>15,'description'=>'Telling time.'],
                ['title'=>'TR A1 My day','type'=>'conversation','xp'=>15,'description'=>'Describe your typical day.'],
            ]],
            ['name'=>'Home & Places','cefr'=>'A1','description'=>'Your home, rooms, and places in town.','lessons'=>[
                ['title'=>'TR A1 House 1','type'=>'vocabulary','xp'=>10,'description'=>'Rooms in the house.'],
                ['title'=>'TR A1 House 2','type'=>'vocabulary','xp'=>10,'description'=>'Furniture and objects.'],
                ['title'=>'TR A1 Places','type'=>'vocabulary','xp'=>10,'description'=>'Places in town.'],
                ['title'=>'TR A1 Directions','type'=>'conversation','xp'=>15,'description'=>'Left, right, straight.'],
                ['title'=>'TR A1 Where is it','type'=>'conversation','xp'=>15,'description'=>'Ask and give directions.'],
            ]],
            ['name'=>'Basic Verbs','cefr'=>'A1','description'=>'Essential verbs for everyday communication.','lessons'=>[
                ['title'=>'TR A1 Verbs 1','type'=>'grammar','xp'=>15,'description'=>'To be, to have, to go.'],
                ['title'=>'TR A1 Verbs 2','type'=>'grammar','xp'=>15,'description'=>'To want, to like, to eat.'],
                ['title'=>'TR A1 Verbs 3','type'=>'grammar','xp'=>15,'description'=>'To speak, to understand, to know.'],
                ['title'=>'TR A1 Questions','type'=>'grammar','xp'=>15,'description'=>'What, where, how, when.'],
                ['title'=>'TR A1 Negation','type'=>'grammar','xp'=>15,'description'=>'Not, no, never.'],
            ]],
            ['name'=>'A1 Exam','cefr'=>'A1','description'=>'Test all your A1 Turkish knowledge.','lessons'=>[
                ['title'=>'A1 Final Exam','type'=>'grammar','xp'=>50,'description'=>'Complete A1 exam.'],
            ]],
        ];
    }

    private function getTurkishA2(): array
    {
        return [
            ['name'=>'At Home','cefr'=>'A2','description'=>'Your home, rooms and furniture.','lessons'=>[
                ['title'=>'TR A2 Rooms','type'=>'vocabulary','xp'=>10,'description'=>'Rooms in the house.'],
                ['title'=>'TR A2 Furniture','type'=>'vocabulary','xp'=>10,'description'=>'Tables, chairs, beds.'],
                ['title'=>'TR A2 Household items','type'=>'vocabulary','xp'=>10,'description'=>'Everyday objects at home.'],
                ['title'=>'TR A2 My home','type'=>'conversation','xp'=>15,'description'=>'Describe where you live.'],
                ['title'=>'TR A2 Housework','type'=>'vocabulary','xp'=>10,'description'=>'Cleaning, cooking, washing.'],
            ]],
            ['name'=>'Daily Routine','cefr'=>'A2','description'=>'Describe your day from morning to night.','lessons'=>[
                ['title'=>'TR A2 Morning routine','type'=>'vocabulary','xp'=>10,'description'=>'Wake up, shower, breakfast.'],
                ['title'=>'TR A2 Work and school','type'=>'vocabulary','xp'=>10,'description'=>'Study, work, commute.'],
                ['title'=>'TR A2 Evening routine','type'=>'vocabulary','xp'=>10,'description'=>'Dinner, relax, sleep.'],
                ['title'=>'TR A2 Weekend activities','type'=>'conversation','xp'=>15,'description'=>'What do you do on weekends?'],
                ['title'=>'TR A2 Describing habits','type'=>'grammar','xp'=>15,'description'=>'Always, sometimes, never.'],
            ]],
            ['name'=>'Time & Calendar','cefr'=>'A2','description'=>'Tell time, make appointments.','lessons'=>[
                ['title'=>'TR A2 Telling time','type'=>'vocabulary','xp'=>10,'description'=>'Hours, minutes, quarter.'],
                ['title'=>'TR A2 Days and weeks','type'=>'vocabulary','xp'=>10,'description'=>'Days, weeks, weekends.'],
                ['title'=>'TR A2 Months and seasons','type'=>'vocabulary','xp'=>10,'description'=>'All months and four seasons.'],
                ['title'=>'TR A2 Dates and years','type'=>'vocabulary','xp'=>10,'description'=>'Dates, years, centuries.'],
                ['title'=>'TR A2 Making appointments','type'=>'conversation','xp'=>15,'description'=>'Schedule meetings and plans.'],
            ]],
            ['name'=>'Weather','cefr'=>'A2','description'=>'Talk about weather and climate.','lessons'=>[
                ['title'=>'TR A2 Weather words','type'=>'vocabulary','xp'=>10,'description'=>'Sun, rain, snow, wind.'],
                ['title'=>'TR A2 Temperature','type'=>'vocabulary','xp'=>10,'description'=>'Hot, cold, warm, cool.'],
                ['title'=>'TR A2 Weather forecast','type'=>'conversation','xp'=>15,'description'=>'What will the weather be?'],
                ['title'=>'TR A2 Seasons and climate','type'=>'vocabulary','xp'=>10,'description'=>'Seasonal weather patterns.'],
            ]],
            ['name'=>'Directions & Transport','cefr'=>'A2','description'=>'Get around town and travel.','lessons'=>[
                ['title'=>'TR A2 Directions','type'=>'vocabulary','xp'=>10,'description'=>'Left, right, straight, turn.'],
                ['title'=>'TR A2 Places in town','type'=>'vocabulary','xp'=>10,'description'=>'Bank, post office, station.'],
                ['title'=>'TR A2 Public transport','type'=>'vocabulary','xp'=>10,'description'=>'Bus, metro, tram, ferry.'],
                ['title'=>'TR A2 Buying tickets','type'=>'conversation','xp'=>15,'description'=>'One ticket to... please.'],
                ['title'=>'TR A2 Asking directions','type'=>'conversation','xp'=>15,'description'=>'How do I get to...?'],
            ]],
            ['name'=>'Shopping','cefr'=>'A2','description'=>'Buy things, talk about prices.','lessons'=>[
                ['title'=>'TR A2 Shops','type'=>'vocabulary','xp'=>10,'description'=>'Bakery, pharmacy, market.'],
                ['title'=>'TR A2 Clothing','type'=>'vocabulary','xp'=>10,'description'=>'Shirt, pants, shoes, jacket.'],
                ['title'=>'TR A2 Prices and money','type'=>'vocabulary','xp'=>10,'description'=>'Lira, expensive, cheap, discount.'],
                ['title'=>'TR A2 At the store','type'=>'conversation','xp'=>15,'description'=>'Can I try this on?'],
                ['title'=>'TR A2 Bargaining','type'=>'conversation','xp'=>15,'description'=>'Is there a discount?'],
            ]],
            ['name'=>'Health & Body','cefr'=>'A2','description'=>'Talk about health and visit the doctor.','lessons'=>[
                ['title'=>'TR A2 Body parts','type'=>'vocabulary','xp'=>10,'description'=>'Head, stomach, back, throat.'],
                ['title'=>'TR A2 Illness','type'=>'vocabulary','xp'=>10,'description'=>'Sick, fever, headache, cold.'],
                ['title'=>'TR A2 At the doctor','type'=>'conversation','xp'=>15,'description'=>'I have a headache since...'],
                ['title'=>'TR A2 At the pharmacy','type'=>'conversation','xp'=>15,'description'=>'I need medicine for...'],
            ]],
            ['name'=>'A2 Grammar','cefr'=>'A2','description'=>'Essential A2 grammar structures.','lessons'=>[
                ['title'=>'TR A2 Past tense','type'=>'grammar','xp'=>15,'description'=>'I went, I ate, I saw.'],
                ['title'=>'TR A2 Future tense','type'=>'grammar','xp'=>15,'description'=>'I will go, I will eat.'],
                ['title'=>'TR A2 Can and must','type'=>'grammar','xp'=>15,'description'=>'I can, I must, I should.'],
                ['title'=>'TR A2 Comparisons','type'=>'grammar','xp'=>15,'description'=>'Bigger, smaller, the best.'],
                ['title'=>'TR A2 Conjunctions','type'=>'grammar','xp'=>15,'description'=>'And, but, because, so.'],
            ]],
            ['name'=>'A2 Exam','cefr'=>'A2','description'=>'Test all your A2 knowledge.','lessons'=>[
                ['title'=>'A2 Final Exam','type'=>'grammar','xp'=>50,'description'=>'Complete A2 exam.'],
            ]],
        ];
    }

    private function getCurriculum(): array
    {
        return [
            // A1
            ['name'=>'Hello World','cefr'=>'A1','description'=>'Greetings and first impressions.','lessons'=>[
                ['title'=>'Greetings','type'=>'vocabulary','xp'=>10,'description'=>'Say hello and goodbye.'],
                ['title'=>'More greetings','type'=>'vocabulary','xp'=>10,'description'=>'Formal and informal.'],
                ['title'=>'Introductions','type'=>'vocabulary','xp'=>10,'description'=>'Introduce yourself.'],
                ['title'=>'About yourself','type'=>'conversation','xp'=>10,'description'=>'Where are you from?'],
                ['title'=>'Basic phrases','type'=>'vocabulary','xp'=>15,'description'=>'Essential phrases.'],
                ['title'=>'Polite expressions','type'=>'conversation','xp'=>15,'description'=>'Please, thank you.'],
            ]],
            ['name'=>'Counting','cefr'=>'A1','description'=>'Numbers and the alphabet.','lessons'=>[
                ['title'=>'Numbers 1-10','type'=>'vocabulary','xp'=>10,'description'=>'One to ten.'],
                ['title'=>'Numbers 11-20','type'=>'vocabulary','xp'=>10,'description'=>'Count to twenty.'],
                ['title'=>'Big numbers','type'=>'vocabulary','xp'=>10,'description'=>'Hundreds, thousands.'],
                ['title'=>'The alphabet','type'=>'vocabulary','xp'=>15,'description'=>'Letters and spelling.'],
                ['title'=>'Spelling practice','type'=>'grammar','xp'=>15,'description'=>'Spell words out.'],
            ]],
            ['name'=>'Family','cefr'=>'A1','description'=>'Your family.','lessons'=>[
                ['title'=>'Family members','type'=>'vocabulary','xp'=>10,'description'=>'Parents, siblings.'],
                ['title'=>'More family','type'=>'vocabulary','xp'=>10,'description'=>'Extended family.'],
                ['title'=>'Describing people','type'=>'vocabulary','xp'=>15,'description'=>'Tall, short, young.'],
                ['title'=>'My family','type'=>'conversation','xp'=>15,'description'=>'Talk about family.'],
                ['title'=>'Ages and birthdays','type'=>'vocabulary','xp'=>10,'description'=>'How old are you?'],
            ]],
            ['name'=>'Colors & Adjectives','cefr'=>'A1','description'=>'Describe the world.','lessons'=>[
                ['title'=>'Colors','type'=>'vocabulary','xp'=>10,'description'=>'Basic colors.'],
                ['title'=>'More colors','type'=>'vocabulary','xp'=>10,'description'=>'Extended palette.'],
                ['title'=>'Adjectives','type'=>'vocabulary','xp'=>15,'description'=>'Big, small, good.'],
                ['title'=>'More adjectives','type'=>'vocabulary','xp'=>15,'description'=>'Fast, slow, easy.'],
                ['title'=>'Describing objects','type'=>'conversation','xp'=>15,'description'=>'What does it look like?'],
            ]],
            ['name'=>'Food & Drink','cefr'=>'A1','description'=>'Food and restaurants.','lessons'=>[
                ['title'=>'Food basics','type'=>'vocabulary','xp'=>10,'description'=>'Essential food.'],
                ['title'=>'More food','type'=>'vocabulary','xp'=>10,'description'=>'Meat, fish, eggs.'],
                ['title'=>'Fruits','type'=>'vocabulary','xp'=>10,'description'=>'Common fruits.'],
                ['title'=>'Drinks','type'=>'vocabulary','xp'=>10,'description'=>'Beverages.'],
                ['title'=>'Meals','type'=>'conversation','xp'=>15,'description'=>'Breakfast, lunch, dinner.'],
                ['title'=>'At the restaurant','type'=>'conversation','xp'=>15,'description'=>'Order food.'],
            ]],
            ['name'=>'A1 Exam','cefr'=>'A1','description'=>'Test your A1 knowledge.','lessons'=>[
                ['title'=>'A1 Final Exam','type'=>'grammar','xp'=>50,'description'=>'Complete A1 exam.'],
            ]],
            // A2
            ['name'=>'At Home','cefr'=>'A2','description'=>'Home and daily life.','lessons'=>[
                ['title'=>'The house','type'=>'vocabulary','xp'=>10,'description'=>'Rooms.'],
                ['title'=>'Furniture','type'=>'vocabulary','xp'=>10,'description'=>'Common furniture.'],
                ['title'=>'Daily routine','type'=>'vocabulary','xp'=>15,'description'=>'Wake, work, sleep.'],
                ['title'=>'Morning routine','type'=>'conversation','xp'=>15,'description'=>'Your morning.'],
                ['title'=>'Housework','type'=>'vocabulary','xp'=>10,'description'=>'Clean, cook, wash.'],
            ]],
            ['name'=>'Time & Calendar','cefr'=>'A2','description'=>'Time and schedules.','lessons'=>[
                ['title'=>'Telling time','type'=>'vocabulary','xp'=>15,'description'=>'What time is it?'],
                ['title'=>'Days of the week','type'=>'vocabulary','xp'=>10,'description'=>'Monday-Sunday.'],
                ['title'=>'Months','type'=>'vocabulary','xp'=>10,'description'=>'January-December.'],
                ['title'=>'Seasons','type'=>'vocabulary','xp'=>10,'description'=>'Spring, summer.'],
                ['title'=>'Making appointments','type'=>'conversation','xp'=>15,'description'=>'Schedule.'],
            ]],
            ['name'=>'Weather & Nature','cefr'=>'A2','description'=>'Weather and outdoors.','lessons'=>[
                ['title'=>'Weather','type'=>'vocabulary','xp'=>10,'description'=>'Sun, rain, wind.'],
                ['title'=>'Outdoor activities','type'=>'vocabulary','xp'=>10,'description'=>'Park, beach.'],
                ['title'=>'Nature walk','type'=>'conversation','xp'=>15,'description'=>'Describe outdoors.'],
            ]],
            ['name'=>'Getting Around','cefr'=>'A2','description'=>'Streets and transport.','lessons'=>[
                ['title'=>'Directions','type'=>'conversation','xp'=>15,'description'=>'Left, right.'],
                ['title'=>'Places in town','type'=>'vocabulary','xp'=>10,'description'=>'Shops, parks.'],
                ['title'=>'Transport','type'=>'vocabulary','xp'=>10,'description'=>'Car, bus, train.'],
                ['title'=>'At the station','type'=>'conversation','xp'=>15,'description'=>'Buy tickets.'],
            ]],
            ['name'=>'Shopping','cefr'=>'A2','description'=>'Buy things.','lessons'=>[
                ['title'=>'Shopping basics','type'=>'conversation','xp'=>15,'description'=>'Buy, sell, price.'],
                ['title'=>'Clothing','type'=>'vocabulary','xp'=>10,'description'=>'Shirts, pants.'],
                ['title'=>'At the market','type'=>'conversation','xp'=>15,'description'=>'Bargain.'],
            ]],
            ['name'=>'A2 Exam','cefr'=>'A2','description'=>'Test A2 knowledge.','lessons'=>[
                ['title'=>'A2 Final Exam','type'=>'grammar','xp'=>50,'description'=>'Complete A2 exam.'],
            ]],
            // B1
            ['name'=>'The Body','cefr'=>'B1','description'=>'Body and health.','lessons'=>[
                ['title'=>'Body parts','type'=>'vocabulary','xp'=>10,'description'=>'Head, hands, feet.'],
                ['title'=>'More body parts','type'=>'vocabulary','xp'=>10,'description'=>'Arms, legs, back.'],
                ['title'=>'At the doctor','type'=>'conversation','xp'=>15,'description'=>'Describe symptoms.'],
                ['title'=>'Staying healthy','type'=>'vocabulary','xp'=>10,'description'=>'Exercise, diet.'],
            ]],
            ['name'=>'Feelings','cefr'=>'B1','description'=>'Emotions.','lessons'=>[
                ['title'=>'Feelings','type'=>'vocabulary','xp'=>10,'description'=>'Happy, sad, angry.'],
                ['title'=>'Emotions','type'=>'vocabulary','xp'=>15,'description'=>'Love, fear, joy.'],
                ['title'=>'Giving advice','type'=>'conversation','xp'=>15,'description'=>'You should.'],
            ]],
            ['name'=>'Free Time','cefr'=>'B1','description'=>'Hobbies.','lessons'=>[
                ['title'=>'Hobbies','type'=>'vocabulary','xp'=>10,'description'=>'Read, cook, swim.'],
                ['title'=>'Sports','type'=>'vocabulary','xp'=>10,'description'=>'Football, tennis.'],
                ['title'=>'Music and art','type'=>'vocabulary','xp'=>10,'description'=>'Music, movies.'],
                ['title'=>'Weekend plans','type'=>'conversation','xp'=>15,'description'=>'What are you doing?'],
            ]],
            ['name'=>'Social Life','cefr'=>'B1','description'=>'Plans and socializing.','lessons'=>[
                ['title'=>'Making plans','type'=>'conversation','xp'=>15,'description'=>'Invite friends.'],
                ['title'=>'Technology','type'=>'vocabulary','xp'=>10,'description'=>'Phone, internet.'],
                ['title'=>'Opinions','type'=>'conversation','xp'=>15,'description'=>'I think, I believe.'],
                ['title'=>'Conversation phrases','type'=>'conversation','xp'=>15,'description'=>'Sound natural.'],
            ]],
            ['name'=>'Travel','cefr'=>'B1','description'=>'Airports and hotels.','lessons'=>[
                ['title'=>'At the airport','type'=>'conversation','xp'=>15,'description'=>'Flights, boarding.'],
                ['title'=>'At the hotel','type'=>'conversation','xp'=>15,'description'=>'Check in.'],
                ['title'=>'Sightseeing','type'=>'vocabulary','xp'=>10,'description'=>'Museums, beaches.'],
                ['title'=>'Emergencies','type'=>'conversation','xp'=>15,'description'=>'Get help.'],
            ]],
            ['name'=>'Nature & Animals','cefr'=>'B1','description'=>'Nature and animals.','lessons'=>[
                ['title'=>'Nature','type'=>'vocabulary','xp'=>10,'description'=>'Trees, rivers.'],
                ['title'=>'Animals','type'=>'vocabulary','xp'=>10,'description'=>'Dogs, cats, birds.'],
            ]],
            ['name'=>'Work & Education','cefr'=>'B1','description'=>'School and careers.','lessons'=>[
                ['title'=>'At school','type'=>'vocabulary','xp'=>10,'description'=>'Teachers, exams.'],
                ['title'=>'Professions','type'=>'vocabulary','xp'=>10,'description'=>'Doctor, lawyer.'],
                ['title'=>'At the office','type'=>'conversation','xp'=>15,'description'=>'Meetings, emails.'],
            ]],
            ['name'=>'Essential Grammar','cefr'=>'B1','description'=>'Core grammar.','lessons'=>[
                ['title'=>'Common verbs 1','type'=>'grammar','xp'=>15,'description'=>'Be, have, go.'],
                ['title'=>'Common verbs 2','type'=>'grammar','xp'=>15,'description'=>'Want, know, speak.'],
                ['title'=>'Common verbs 3','type'=>'grammar','xp'=>15,'description'=>'Give, think.'],
                ['title'=>'Past tense basics','type'=>'grammar','xp'=>20,'description'=>'What happened.'],
                ['title'=>'Future tense','type'=>'grammar','xp'=>20,'description'=>'What will happen.'],
            ]],
            ['name'=>'B1 Exam','cefr'=>'B1','description'=>'Test B1.','lessons'=>[
                ['title'=>'B1 Final Exam','type'=>'grammar','xp'=>50,'description'=>'Complete B1 exam.'],
            ]],
            // B2
            ['name'=>'Work & Career','cefr'=>'B2','description'=>'Professional language.','lessons'=>[
                ['title'=>'Job interviews','type'=>'conversation','xp'=>15,'description'=>'Interview questions.'],
                ['title'=>'The workplace','type'=>'vocabulary','xp'=>10,'description'=>'Colleagues, deadlines.'],
                ['title'=>'Writing emails','type'=>'grammar','xp'=>15,'description'=>'Formal emails.'],
                ['title'=>'Presentations','type'=>'conversation','xp'=>15,'description'=>'Present ideas.'],
            ]],
            ['name'=>'Media & News','cefr'=>'B2','description'=>'News and media.','lessons'=>[
                ['title'=>'Reading the news','type'=>'vocabulary','xp'=>15,'description'=>'Headlines.'],
                ['title'=>'Politics','type'=>'vocabulary','xp'=>10,'description'=>'Government, elections.'],
                ['title'=>'Economy','type'=>'vocabulary','xp'=>10,'description'=>'Money, markets.'],
            ]],
            ['name'=>'Relationships','cefr'=>'B2','description'=>'Complex relationships.','lessons'=>[
                ['title'=>'Describing personality','type'=>'vocabulary','xp'=>10,'description'=>'Ambitious, generous.'],
                ['title'=>'Conflict and resolution','type'=>'conversation','xp'=>15,'description'=>'Disagree politely.'],
                ['title'=>'Life events','type'=>'vocabulary','xp'=>10,'description'=>'Marriage, milestones.'],
            ]],
            ['name'=>'Health & Wellness','cefr'=>'B2','description'=>'Health in depth.','lessons'=>[
                ['title'=>'Mental health','type'=>'vocabulary','xp'=>15,'description'=>'Stress, anxiety.'],
                ['title'=>'Fitness & diet','type'=>'vocabulary','xp'=>10,'description'=>'Exercise, nutrition.'],
                ['title'=>'Medical conversations','type'=>'conversation','xp'=>15,'description'=>'Explain symptoms.'],
            ]],
            ['name'=>'Advanced Grammar 1','cefr'=>'B2','description'=>'Complex structures.','lessons'=>[
                ['title'=>'Conditional sentences','type'=>'grammar','xp'=>20,'description'=>'If I were you.'],
                ['title'=>'Passive voice','type'=>'grammar','xp'=>20,'description'=>'Was written by.'],
                ['title'=>'Reported speech','type'=>'grammar','xp'=>20,'description'=>'She said that.'],
            ]],
            ['name'=>'Culture & Society','cefr'=>'B2','description'=>'Culture and traditions.','lessons'=>[
                ['title'=>'Traditions','type'=>'vocabulary','xp'=>10,'description'=>'Festivals, customs.'],
                ['title'=>'Art & literature','type'=>'vocabulary','xp'=>10,'description'=>'Books, paintings.'],
                ['title'=>'Debating','type'=>'conversation','xp'=>15,'description'=>'Argue persuasively.'],
            ]],
            ['name'=>'B2 Exam','cefr'=>'B2','description'=>'Test B2.','lessons'=>[
                ['title'=>'B2 Final Exam','type'=>'grammar','xp'=>50,'description'=>'Complete B2 exam.'],
            ]],
            // C1
            ['name'=>'Abstract Thinking','cefr'=>'C1','description'=>'Complex abstract ideas.','lessons'=>[
                ['title'=>'Philosophy','type'=>'vocabulary','xp'=>15,'description'=>'Truth, existence.'],
                ['title'=>'Hypotheticals','type'=>'grammar','xp'=>20,'description'=>'What if.'],
                ['title'=>'Nuanced opinions','type'=>'conversation','xp'=>15,'description'=>'Subtle meanings.'],
            ]],
            ['name'=>'Academic Language','cefr'=>'C1','description'=>'Academic contexts.','lessons'=>[
                ['title'=>'Academic vocabulary','type'=>'vocabulary','xp'=>15,'description'=>'Research, analysis.'],
                ['title'=>'Writing essays','type'=>'grammar','xp'=>20,'description'=>'Structure arguments.'],
                ['title'=>'Citing and referencing','type'=>'grammar','xp'=>15,'description'=>'According to.'],
            ]],
            ['name'=>'Business Advanced','cefr'=>'C1','description'=>'High-level professional.','lessons'=>[
                ['title'=>'Negotiations','type'=>'conversation','xp'=>20,'description'=>'Reach agreements.'],
                ['title'=>'Legal language','type'=>'vocabulary','xp'=>15,'description'=>'Contracts, terms.'],
                ['title'=>'Financial reports','type'=>'vocabulary','xp'=>15,'description'=>'Revenue, profit.'],
            ]],
            ['name'=>'Idiomatic Expressions','cefr'=>'C1','description'=>'Idioms and slang.','lessons'=>[
                ['title'=>'Common idioms','type'=>'vocabulary','xp'=>15,'description'=>'Break the ice.'],
                ['title'=>'Slang and colloquial','type'=>'vocabulary','xp'=>15,'description'=>'Informal language.'],
                ['title'=>'Proverbs and sayings','type'=>'vocabulary','xp'=>15,'description'=>'Traditional wisdom.'],
            ]],
            ['name'=>'Advanced Grammar 2','cefr'=>'C1','description'=>'Most complex structures.','lessons'=>[
                ['title'=>'Subjunctive mood','type'=>'grammar','xp'=>20,'description'=>'Wishes, doubts.'],
                ['title'=>'Complex connectors','type'=>'grammar','xp'=>20,'description'=>'Nevertheless.'],
                ['title'=>'Inversion and emphasis','type'=>'grammar','xp'=>20,'description'=>'Not only but also.'],
            ]],
            ['name'=>'C1 Exam','cefr'=>'C1','description'=>'Test C1.','lessons'=>[
                ['title'=>'C1 Final Exam','type'=>'grammar','xp'=>50,'description'=>'Complete C1 exam.'],
            ]],
            // C2
            ['name'=>'Literary Language','cefr'=>'C2','description'=>'Literature and analysis.','lessons'=>[
                ['title'=>'Literary analysis','type'=>'vocabulary','xp'=>20,'description'=>'Metaphor, irony.'],
                ['title'=>'Poetry and prose','type'=>'vocabulary','xp'=>15,'description'=>'Rhythm, tone.'],
                ['title'=>'Critical writing','type'=>'grammar','xp'=>20,'description'=>'Reviews, critiques.'],
                ['title'=>'Creative writing','type'=>'grammar','xp'=>20,'description'=>'Short stories.'],
            ]],
            ['name'=>'Rhetoric & Persuasion','cefr'=>'C2','description'=>'Persuasive communication.','lessons'=>[
                ['title'=>'Rhetorical devices','type'=>'vocabulary','xp'=>20,'description'=>'Analogy, contrast.'],
                ['title'=>'Public speaking','type'=>'conversation','xp'=>20,'description'=>'Compelling speeches.'],
                ['title'=>'Persuasive writing','type'=>'grammar','xp'=>20,'description'=>'Convince through text.'],
            ]],
            ['name'=>'Specialized Vocabulary','cefr'=>'C2','description'=>'Domain-specific.','lessons'=>[
                ['title'=>'Science & technology','type'=>'vocabulary','xp'=>15,'description'=>'AI, algorithms.'],
                ['title'=>'Law & governance','type'=>'vocabulary','xp'=>15,'description'=>'Legislation, rights.'],
                ['title'=>'Medicine','type'=>'vocabulary','xp'=>15,'description'=>'Diagnosis, treatment.'],
                ['title'=>'Environment','type'=>'vocabulary','xp'=>15,'description'=>'Climate, ecology.'],
            ]],
            ['name'=>'Native-Level Expression','cefr'=>'C2','description'=>'Full fluency.','lessons'=>[
                ['title'=>'Humor and sarcasm','type'=>'conversation','xp'=>20,'description'=>'Understand wit.'],
                ['title'=>'Regional variations','type'=>'vocabulary','xp'=>15,'description'=>'Dialects.'],
                ['title'=>'Improvisation','type'=>'conversation','xp'=>20,'description'=>'Think on feet.'],
                ['title'=>'Mastery review','type'=>'conversation','xp'=>25,'description'=>'Prove fluency.'],
            ]],
            ['name'=>'C2 Final Exam','cefr'=>'C2','description'=>'The ultimate test.','lessons'=>[
                ['title'=>'C2 Final Exam','type'=>'grammar','xp'=>50,'description'=>'Ultimate mastery.'],
            ]],
        ];
    }
}
