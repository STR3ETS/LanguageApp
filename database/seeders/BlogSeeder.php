<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Learning tips', 'slug' => 'learning-tips', 'icon' => 'fa-solid fa-lightbulb', 'color' => 'indigo'],
            ['name' => 'Science', 'slug' => 'science', 'icon' => 'fa-solid fa-brain', 'color' => 'mint'],
            ['name' => 'Product update', 'slug' => 'product-update', 'icon' => 'fa-solid fa-rocket', 'color' => 'sun'],
            ['name' => 'Community', 'slug' => 'community', 'icon' => 'fa-solid fa-users', 'color' => 'rose'],
            ['name' => 'Behind the scenes', 'slug' => 'behind-the-scenes', 'icon' => 'fa-solid fa-palette', 'color' => 'sky'],
            ['name' => 'Opinion', 'slug' => 'opinion', 'icon' => 'fa-solid fa-scale-balanced', 'color' => 'rose'],
        ];

        foreach ($categories as $cat) {
            BlogCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $posts = [
            [
                'category' => 'learning-tips',
                'title' => 'Why 5 minutes a day beats 1 hour a week',
                'slug' => 'why-5-minutes-a-day-beats-1-hour-a-week',
                'excerpt' => 'We analyzed data from over 2,000 Fluence learners and found a clear pattern: those who practice just 5 minutes daily retain 3x more vocabulary than those who do longer weekly sessions. Here\'s why consistency trumps intensity — and how to build a daily habit that sticks.',
                'read_time' => '8 min read',
                'is_featured' => true,
                'published_at' => '2026-03-28',
                'body' => <<<'MD'
## The data is clear

We looked at vocabulary retention rates across 2,000+ active Fluence learners over a 3-month period. The results were striking:

- **Daily learners** (5-10 min/day): 78% vocabulary retention after 30 days
- **Weekly learners** (30-60 min/week): 23% vocabulary retention after 30 days
- **Sporadic learners** (random sessions): 12% vocabulary retention after 30 days

The daily learners weren't spending more total time — in fact, they spent *less* time overall. They just spread it out consistently.

## Why does this work?

It comes down to how memory works. When you learn a new word, your brain creates a temporary neural pathway. If you don't revisit that word within 24 hours, the pathway starts to weaken. But if you come back the next day, even briefly, the pathway strengthens.

This is the core principle behind **spaced repetition** — the learning method that powers Fluence's review system. Instead of cramming everything into one session, you review words at increasing intervals: after 1 day, then 3 days, then 7 days, then 14 days.

## The habit loop

There's another reason daily practice works: it builds a habit. When you practice at the same time every day — during your morning coffee, on your commute, before bed — it becomes automatic. You stop needing willpower and start running on routine.

This is why Fluence has a streak system. It's not about gamification for its own sake. It's about helping you build the most powerful learning tool: consistency.

## How to build your 5-minute habit

1. **Choose a trigger**: Link your Fluence session to something you already do daily (e.g., "after my morning coffee")
2. **Start ridiculously small**: Even 2 minutes counts. The goal is showing up, not marathon sessions
3. **Never miss twice**: If you miss a day, that's fine. But never miss two days in a row
4. **Track your streak**: The visual progress of a growing streak is surprisingly motivating

## The bottom line

You don't need to find an hour. You need to find five minutes, every day. Your future self will thank you.

Start your streak today. It's free.
MD,
            ],
            [
                'category' => 'science',
                'title' => 'How spaced repetition actually works',
                'slug' => 'how-spaced-repetition-actually-works',
                'excerpt' => 'A deep dive into the algorithm that powers Fluence\'s review system. We explain the Ebbinghaus forgetting curve, how we calculate optimal review intervals, and why you remember words you learned weeks ago.',
                'read_time' => '12 min read',
                'is_featured' => false,
                'published_at' => '2026-03-20',
                'body' => <<<'MD'
## The forgetting curve

In 1885, German psychologist Hermann Ebbinghaus discovered something fascinating: we forget new information in a predictable pattern. Within 24 hours of learning something new, we forget about 70% of it. Within a week, we've lost about 90%.

This sounds depressing, but there's a silver lining: every time you review the material, the forgetting curve gets flatter. The first review might buy you 2 days. The second review buys you 5 days. The third buys you 2 weeks. Eventually, the word is in your long-term memory.

## How Fluence's algorithm works

Every word you learn in Fluence gets a "memory strength" score from 0 to 100. Here's what happens:

1. **New word learned**: Memory strength starts at 50
2. **Correct answer**: Memory strength increases (amount depends on current strength)
3. **Wrong answer**: Memory strength decreases significantly
4. **Time passes**: Memory strength gradually decays based on the forgetting curve

When a word's memory strength drops below a threshold, it gets scheduled for review. Words you struggle with (low strength) appear more often. Words you know well (high strength) appear less often.

## The math behind the intervals

We use a modified version of the SM-2 algorithm (the same foundation used by Anki, one of the most popular spaced repetition tools). But we've adapted it for language learning specifically:

- **Easy words** (consistently correct): Intervals double each time (1 day → 2 days → 4 days → 8 days → 16 days)
- **Medium words** (sometimes wrong): Intervals grow more slowly (1 day → 2 days → 3 days → 5 days → 8 days)
- **Hard words** (frequently wrong): Intervals stay short until you demonstrate mastery (1 day → 1 day → 2 days → 3 days)

## Why it feels like magic

After using Fluence for a few weeks, most learners have a moment of surprise: they remember a word they learned in week one, without having studied it recently. That's spaced repetition working as designed.

The beauty of the system is that you don't have to think about it. You just show up, do your lesson, and the algorithm handles the rest. It knows what you need to review and when.

## Active recall: the other piece

Spaced repetition only works when combined with **active recall** — the act of retrieving an answer from memory rather than passively recognizing it. Every exercise in Fluence is a mini-test: we show you a word and you have to produce the translation, not just recognize it from a list.

Research shows that active recall strengthens memory 2-3x more than passive review. Combined with spaced repetition, it's the most efficient way to learn vocabulary that science has found.

## Start building your memory

Every lesson you complete in Fluence feeds the algorithm with data about your memory patterns. The more you practice, the smarter it gets at scheduling your reviews. After about 2 weeks of daily practice, the system has a solid model of your memory and reviews become increasingly personalized.
MD,
            ],
            [
                'category' => 'product-update',
                'title' => 'New: Japanese and Chinese now available',
                'slug' => 'japanese-and-chinese-now-available',
                'excerpt' => 'We\'ve expanded our language library with two of the most requested languages. Both include full A1 through B2 courses, with C1 and C2 coming later this year. Here\'s what\'s included and what to expect.',
                'read_time' => '5 min read',
                'is_featured' => false,
                'published_at' => '2026-03-12',
                'body' => <<<'MD'
## Two new languages

We're excited to announce that Japanese and Chinese (Mandarin) are now available on Fluence. These were by far the two most requested languages from our community, and we're thrilled to finally deliver them.

Both languages include:
- **Full A1 through B2 courses** (C1 and C2 coming Q3 2026)
- **Native audio pronunciation** for every word and sentence
- **All exercise types**: translation, matching, fill-in-the-blank, and listening
- **Spaced repetition** optimized for character-based languages

## What makes these courses special

Learning Japanese and Chinese is different from learning European languages. You're not just learning vocabulary — you're learning entirely new writing systems. We've adapted our courses accordingly:

**Japanese** includes dedicated Hiragana and Katakana recognition exercises in A1, with Kanji introduced gradually from A2 onwards. Romaji is available as a helper in early lessons but fades as you progress.

**Chinese** uses Pinyin alongside Simplified Chinese characters from the start. Tone exercises are integrated into every lesson because getting tones right is essential for comprehension.

## Built with native speakers

Every lesson was created in collaboration with native speakers and professional language teachers. We didn't just translate our European courses — we built these from the ground up to respect the unique structure of each language.

## Available now

Both languages are available today for all Premium and Family plan users. Free plan users can try Japanese or Chinese at A1 level (if it's your chosen free language).

Happy learning! 🇯🇵🇨🇳
MD,
            ],
            [
                'category' => 'community',
                'title' => 'From A1 to ordering food: Sarah\'s story',
                'slug' => 'from-a1-to-ordering-food-sarahs-story',
                'excerpt' => 'How one learner went from zero Spanish to confidently ordering at a restaurant in Madrid in just 3 months. Sarah shares her routine, her tips, and the moment she realized Fluence was actually working.',
                'read_time' => '6 min read',
                'is_featured' => false,
                'published_at' => '2026-03-05',
                'body' => <<<'MD'
## "I'd tried everything"

Sarah K. from London had tried Duolingo, Babbel, YouTube tutorials, and even a Spanish textbook. Nothing stuck. She'd start strong, last a week or two, and then life would get in the way.

"The problem wasn't motivation," Sarah told us. "It was that the apps never made me feel like I was actually getting somewhere. I'd do lessons but I couldn't use any of it in real life."

## The daily routine

Sarah started Fluence in December 2025 with a simple goal: learn enough Spanish to order food on her trip to Madrid in March 2026.

Her routine was simple:
- **7:15 AM**: One Fluence lesson during morning coffee (5 minutes)
- **12:30 PM**: Quick review session during lunch break (3 minutes)
- **That's it.** No hour-long study sessions. No grammar books.

## The streak that changed everything

"Around day 10, I realized I didn't want to break my streak. It sounds silly, but that little flame icon became something I was proud of. By day 20, it wasn't about the streak anymore — I was actually understanding Spanish."

Sarah's streak eventually reached 34 days before her Madrid trip. During that time, she completed all of A1 and was halfway through A2.

## The moment of truth

"We went to a restaurant in Malasaña. The waiter came over and I just... ordered. In Spanish. Not perfectly, but he understood me. I said 'Me gustaría la paella, por favor' and he smiled and said 'Perfecto.' I nearly cried."

## Sarah's tips

1. **Same time every day.** "Attaching it to my coffee made it automatic."
2. **Don't skip the hard words.** "The spaced repetition brings them back. Trust the system."
3. **Use what you learn immediately.** "I labeled things in my kitchen in Spanish. My flatmate thought I was insane."
4. **The streak is your friend.** "It's not about the number. It's about the habit."

## Where Sarah is now

Sarah is currently on a 67-day streak and working through B1. She's planning a month in Barcelona this summer. "I want to be able to have actual conversations. Based on my progress, I think I'll get there."

*Want to share your story? Email us at hello@fluence.com.*
MD,
            ],
            [
                'category' => 'science',
                'title' => 'The streak effect: our data speaks',
                'slug' => 'the-streak-effect-our-data-speaks',
                'excerpt' => 'We crunched the numbers. Users with a 7+ day streak retain 3x more vocabulary, complete 5x more lessons, and are 8x more likely to reach A2. Here\'s the full breakdown.',
                'read_time' => '10 min read',
                'is_featured' => false,
                'published_at' => '2026-02-25',
                'body' => <<<'MD'
## We love data

At Fluence, we track learning outcomes (anonymized, of course) to understand what actually works. We recently analyzed 3 months of data across our entire user base, and the results around streaks were remarkable.

## The numbers

We compared three groups:

| Metric | No streak (0-2 days) | Short streak (3-6 days) | Long streak (7+ days) |
|--------|---------------------|------------------------|----------------------|
| Vocabulary retention (30 days) | 15% | 45% | 78% |
| Lessons completed per month | 4 | 18 | 42 |
| Reached A2 level | 3% | 22% | 48% |
| Still active after 90 days | 8% | 35% | 72% |

The differences are staggering. Users with a 7+ day streak aren't just slightly better — they're in a completely different league.

## Why streaks work

The streak itself doesn't make you learn faster. What it does is solve the hardest problem in language learning: **showing up consistently**.

Once you have a streak going, three psychological mechanisms kick in:

1. **Loss aversion**: You don't want to lose your streak. This is more motivating than wanting to gain something new.
2. **Identity shift**: After 7+ days, you start thinking of yourself as "someone who learns Spanish every day" rather than "someone who's trying to learn Spanish."
3. **Compound effect**: Each day builds on the previous one. Spaced repetition works better with daily input. Vocabulary connects. Grammar patterns emerge.

## The critical window: days 3-7

Our data shows that days 3-7 are the make-or-break window. If a user gets past day 7, there's a 72% chance they'll still be active 90 days later. If they drop off before day 7, that chance drops to 8%.

This is why we're investing heavily in the first-week experience: onboarding, notifications, and encouragement are all optimized for getting you past that critical 7-day mark.

## What we're doing about it

Based on this data, we're working on several features:
- **Streak freeze**: Miss a day without losing your streak (coming soon)
- **Streak milestones**: Special celebrations at 7, 30, 100, and 365 days
- **Family streaks**: Shared accountability on the Family plan
- **Smart reminders**: Notifications timed to when you're most likely to practice

## Start your streak

If you take one thing from this article, let it be this: get to day 7. After that, the habit takes over and the learning compounds. Five minutes a day. That's all it takes.
MD,
            ],
            [
                'category' => 'product-update',
                'title' => 'Family plan: learn together, grow together',
                'slug' => 'family-plan-learn-together-grow-together',
                'excerpt' => 'The Fluence Family plan isn\'t just "Premium times three." It\'s designed around shared accountability: family streaks, progress overviews, and the motivation that comes from learning alongside people you love.',
                'read_time' => '7 min read',
                'is_featured' => false,
                'published_at' => '2026-02-18',
                'body' => <<<'MD'
## More than shared billing

When we designed the Family plan, we could have just made it "Premium for multiple accounts" and called it a day. But we wanted something more meaningful.

The Family plan is built around a simple insight: **people learn better when they're accountable to someone they care about.**

## What's included

The Family plan (€9.99/month or €14.99 monthly) includes:

- **Up to 3 accounts** with individual profiles
- **Everything in Premium** for each account
- **Family progress overview**: See how everyone is doing at a glance
- **Shared family streak**: The family streak only breaks if *everyone* misses a day
- **Individual learning paths**: Everyone chooses their own language(s) and level

## The shared streak

This is the feature our Family plan users love most. The family streak tracks whether at least one family member practiced today. As long as someone in the family learns, the streak grows.

But here's the twist: if everyone misses a day, the streak resets. This creates gentle accountability. "Did you do your Fluence today?" has become a common dinner table question for our Family plan users.

## Real families, real results

David R. from New York started the Family plan with his two kids (ages 12 and 14). They're learning Dutch together before a trip to Amsterdam.

"The shared streak is genius," David told us. "My son forgot one evening and my daughter literally reminded him before bed. They hold each other accountable in a way I never could as a parent."

## How to get started

1. Sign up for the Family plan
2. Invite up to 2 family members via email
3. Each person sets up their own profile, language, and goals
4. Start learning together

The first 7 days are free, and you can cancel anytime.
MD,
            ],
            [
                'category' => 'learning-tips',
                'title' => 'The best time to learn a language (it\'s not what you think)',
                'slug' => 'the-best-time-to-learn-a-language',
                'excerpt' => 'Morning people swear by pre-breakfast sessions. Night owls prefer winding down with a lesson. We looked at our data to find out when Fluence users actually learn best — and the answer surprised us.',
                'read_time' => '6 min read',
                'is_featured' => false,
                'published_at' => '2026-02-10',
                'body' => <<<'MD'
## The debate

Every productivity blog has an opinion: "Learn in the morning when your brain is fresh!" or "Evening study is better because you sleep on it!" or "Lunch breaks are the sweet spot!"

We decided to settle this with data.

## What our data shows

We analyzed lesson completion rates and vocabulary retention across different time windows:

| Time window | Completion rate | Retention (7 days) |
|-------------|----------------|-------------------|
| 6-9 AM | 82% | 71% |
| 9-12 PM | 76% | 68% |
| 12-2 PM | 68% | 65% |
| 2-5 PM | 61% | 59% |
| 5-8 PM | 73% | 67% |
| 8-11 PM | 79% | 72% |

Morning and evening learners perform similarly and both outperform afternoon learners. But here's the surprising part...

## The real answer

The best time to learn is **the time you'll actually do it consistently**.

When we controlled for streak length (i.e., comparing people who practice daily regardless of time), the differences between morning and evening nearly disappeared. The afternoon dip remained, likely because people are more distracted during work hours.

## Our recommendation

1. **Pick a time that works for your schedule** — morning coffee, evening wind-down, or commute
2. **Attach it to an existing habit** — this is called "habit stacking" and it's the most reliable way to build consistency
3. **Avoid the 2-5 PM window** if possible — energy and focus are typically lowest
4. **Be consistent** — the same time every day matters more than the "optimal" time

The person who practices at 10 PM every night will outlearn the person who aims for 7 AM but only manages it three times a week.

## Don't overthink it

If you're reading this article to figure out the perfect time to start learning, here's our advice: start now. Open Fluence, do one lesson, and then do it again tomorrow at whatever time works. Perfection is the enemy of progress.
MD,
            ],
            [
                'category' => 'behind-the-scenes',
                'title' => 'How we design lessons at Fluence',
                'slug' => 'how-we-design-lessons-at-fluence',
                'excerpt' => 'A behind-the-scenes look at how our content team creates lessons. From word selection and sentence construction to exercise flow and difficulty balancing — every lesson goes through 5 review stages.',
                'read_time' => '9 min read',
                'is_featured' => false,
                'published_at' => '2026-02-03',
                'body' => <<<'MD'
## Not just translation

A common misconception is that creating a language course is mostly translation work. In reality, it's closer to game design meets educational psychology.

Every lesson in Fluence goes through 5 stages before it reaches you:

## Stage 1: Word selection

We don't teach random vocabulary. Each level follows a carefully curated word list based on frequency analysis — the most commonly used words in the target language. A1 covers the 300 most frequent words, which account for roughly 65% of everyday conversation.

We also consider **teachability**: some common words are grammatically complex and better saved for later levels. The order matters.

## Stage 2: Sentence construction

Once we have the word list, our content team (native speakers + language teachers) creates sentences that:
- Use only words from the current level or below
- Demonstrate the target word in a natural context
- Are culturally appropriate and relevant
- Gradually increase in complexity within the lesson

## Stage 3: Exercise design

Each lesson contains 8-12 exercises mixing different types:
- **Translation** (both directions): Tests production and comprehension
- **Word matching**: Builds quick recall under mild time pressure
- **Fill-in-the-blank**: Tests grammar and context understanding
- **Listening**: Trains audio recognition with native pronunciation

The order is deliberate: easier exercises come first to build confidence, harder ones come later when you're warmed up.

## Stage 4: Difficulty balancing

We run every new lesson through our internal testing tool that simulates a learner with average memory. If the simulated learner scores below 60% on first attempt, the lesson is too hard. Above 90%, it's too easy. We aim for 70-80% — the sweet spot where you're challenged but not frustrated.

## Stage 5: Native speaker review

Before publication, every lesson is reviewed by at least one native speaker who isn't part of the content team. They check for:
- Natural phrasing (does this sound like something a native would actually say?)
- Cultural sensitivity
- Audio pronunciation accuracy
- Exercise clarity

## Continuous improvement

After launch, we monitor exercise-level completion rates. If a specific exercise has an unusually high failure rate, it goes back for review. Our lessons get better over time based on real learner data.

This is why we'd rather have 11 excellent language courses than 50 mediocre ones. Quality takes time, and we're committed to getting it right.
MD,
            ],
            [
                'category' => 'opinion',
                'title' => 'Duolingo vs Fluence: an honest comparison',
                'slug' => 'duolingo-vs-fluence-an-honest-comparison',
                'excerpt' => 'We respect Duolingo — they made language learning mainstream. But we built Fluence for a different audience. Here\'s where we overlap, where we differ, and who each app is best for.',
                'read_time' => '11 min read',
                'is_featured' => false,
                'published_at' => '2026-01-28',
                'body' => <<<'MD'
## Let's be honest

Writing a comparison between your product and a competitor is tricky. We want to be honest, not just promotional. So here's our genuine take.

## Where Duolingo wins

- **More languages** (40+ vs our 11): If you want to learn Finnish or Hawaiian, Duolingo is your only option
- **Larger community**: More learners means more social features, forums, and shared content
- **Completely free tier**: Duolingo's free tier is more generous (with ads)
- **Brand recognition**: Everyone knows Duolingo. The green owl is iconic

## Where Fluence wins

- **No ads, ever**: Even our free plan is ad-free. We believe ads disrupt learning
- **Deeper spaced repetition**: Our algorithm is specifically optimized for vocabulary retention
- **Premium design**: We invest heavily in UI/UX. Learning should feel premium, not cluttered
- **Focused curriculum**: Fewer languages but deeper, more structured courses based on CEFR
- **Family plan**: Designed for shared learning with accountability features

## The fundamental difference

Duolingo is built to maximize daily active users. Their business model depends on engagement metrics and ad revenue. This leads to design decisions that prioritize "time in app" over "learning outcomes" — hearts, gems, leagues, and other mechanics that keep you playing but don't necessarily help you learn.

Fluence is built to maximize learning outcomes. We charge for Premium because that aligns our incentives with yours: you pay us to help you learn, so we focus on making you learn as efficiently as possible.

## Who should use what?

**Choose Duolingo if:**
- You want a completely free experience and don't mind ads
- You're learning a less common language we don't offer
- You enjoy competitive social features (leagues, friend rankings)

**Choose Fluence if:**
- You want science-backed learning without distractions
- You value a premium, ad-free experience
- You're serious about progressing through CEFR levels
- You want a family learning experience
- You want spaced repetition that actually works

## Our honest take

We respect what Duolingo has built. They made language learning mainstream and accessible to millions. We just think there's room for something different — an app that prioritizes depth over breadth, quality over quantity, and learning over engagement.

That's what we're building. And if you try both and prefer Duolingo, that's totally fine. The important thing is that you're learning.
MD,
            ],
        ];

        foreach ($posts as $post) {
            $category = BlogCategory::where('slug', $post['category'])->first();

            BlogPost::updateOrCreate(
                ['slug' => $post['slug']],
                [
                    'blog_category_id' => $category->id,
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'read_time' => $post['read_time'],
                    'is_featured' => $post['is_featured'],
                    'is_published' => true,
                    'published_at' => $post['published_at'],
                ]
            );
        }
    }
}
