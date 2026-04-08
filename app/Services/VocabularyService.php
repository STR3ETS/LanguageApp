<?php

namespace App\Services;

class VocabularyService
{
    /**
     * Lesson title -> word bank key mapping.
     * Maps curriculum lesson titles to vocabulary bank keys.
     */
    private const LESSON_KEY_MAP = [
        // Module 1
        'greetings' => 'greetings',
        'introductions' => 'introductions',
        'yes and no' => 'basic phrases',
        'basic phrases' => 'basic phrases',
        'numbers 1-10' => 'numbers 1-10',
        'numbers 11-20' => 'numbers 1-10',  // fallback to 1-10 if 11-20 doesn't exist
        'the alphabet' => 'basic phrases',

        // Module 2
        'family members' => 'family members',
        'more family' => 'family members',
        'describing people' => 'family members',
        'colors' => 'colors',
        'more colors' => 'colors',
        'adjectives' => 'colors',
        'more adjectives' => 'colors',

        // Module 3
        'food basics' => 'food basics',
        'more food' => 'food basics',
        'fruits' => 'food basics',
        'drinks' => 'food basics',
        'meals' => 'food basics',
        'at the restaurant' => 'food basics',

        // Module 4
        'the house' => 'the house',
        'furniture' => 'the house',
        'daily routine' => 'daily routine',
        'telling time' => 'days of the week',
        'days of the week' => 'days of the week',
        'months' => 'days of the week',

        // Module 5
        'weather' => 'weather',
        'seasons' => 'weather',
        'directions' => 'basic phrases',
        'places in town' => 'the house',
        'transport' => 'transport',
        'at the station' => 'transport',
        'shopping basics' => 'basic phrases',
        'clothing' => 'colors',

        // Module 6
        'body parts' => 'body parts',
        'more body parts' => 'body parts',
        'at the doctor' => 'body parts',
        'feelings' => 'feelings',
        'emotions' => 'feelings',

        // Module 7
        'hobbies' => 'hobbies',
        'sports' => 'hobbies',
        'music and art' => 'hobbies',
        'making plans' => 'basic phrases',
        'technology' => 'basic phrases',
        'opinions' => 'basic phrases',
        'conversation phrases' => 'basic phrases',

        // Module 8
        'at the airport' => 'transport',
        'booking' => 'basic phrases',
        'at the hotel' => 'the house',
        'sightseeing' => 'basic phrases',
        'emergencies' => 'basic phrases',

        // Module 9
        'nature' => 'animals',
        'animals' => 'animals',

        // Module 10
        'at school' => 'professions',
        'professions' => 'professions',
        'at the office' => 'professions',

        // Module 11
        'common verbs 1' => 'common verbs',
        'common verbs 2' => 'common verbs',
        'common verbs 3' => 'common verbs',
        'past tense basics' => 'common verbs',
        'future tense' => 'common verbs',

        // B2
        'job interviews' => 'professions',
        'the workplace' => 'professions',
        'writing emails' => 'basic phrases',
        'presentations' => 'basic phrases',
        'reading the news' => 'basic phrases',
        'politics' => 'basic phrases',
        'economy' => 'basic phrases',
        'describing personality' => 'feelings',
        'conflict and resolution' => 'feelings',
        'life events' => 'family members',
        'mental health' => 'feelings',
        'fitness & diet' => 'food basics',
        'medical conversations' => 'body parts',
        'conditional sentences' => 'common verbs',
        'passive voice' => 'common verbs',
        'reported speech' => 'common verbs',
        'traditions' => 'basic phrases',
        'art & literature' => 'hobbies',
        'debating' => 'basic phrases',

        // C1
        'philosophy' => 'basic phrases',
        'hypotheticals' => 'common verbs',
        'nuanced opinions' => 'basic phrases',
        'academic vocabulary' => 'professions',
        'writing essays' => 'basic phrases',
        'citing and referencing' => 'basic phrases',
        'negotiations' => 'professions',
        'legal language' => 'professions',
        'financial reports' => 'professions',
        'common idioms' => 'basic phrases',
        'slang and colloquial' => 'basic phrases',
        'proverbs and sayings' => 'basic phrases',
        'subjunctive mood' => 'common verbs',
        'complex connectors' => 'common verbs',
        'inversion and emphasis' => 'common verbs',

        // C2
        'literary analysis' => 'basic phrases',
        'poetry and prose' => 'basic phrases',
        'critical writing' => 'basic phrases',
        'rhetorical devices' => 'basic phrases',
        'public speaking' => 'basic phrases',
        'persuasive writing' => 'basic phrases',
        'science & technology' => 'professions',
        'law & governance' => 'professions',
        'medicine' => 'body parts',
        'environment' => 'animals',
        'humor and sarcasm' => 'basic phrases',
        'regional variations' => 'basic phrases',
        'improvisation' => 'basic phrases',
        'mastery review' => 'greetings',
    ];

    public function getWordPairs(string $lessonSlug, string $language): array
    {
        $bank = $this->getBank($language);
        $key = strtolower(trim($lessonSlug));

        // Direct match
        if (isset($bank[$key])) {
            return $bank[$key];
        }

        // Map lesson title to bank key
        $mappedKey = self::LESSON_KEY_MAP[$key] ?? null;
        if ($mappedKey && isset($bank[$mappedKey])) {
            return $bank[$mappedKey];
        }

        // Keyword search: find a bank key that shares a word with the lesson title
        $titleWords = explode(' ', $key);
        foreach ($bank as $bankKey => $pairs) {
            foreach ($titleWords as $word) {
                if (strlen($word) > 3 && str_contains($bankKey, $word)) {
                    return $pairs;
                }
            }
        }

        // Last resort: return a random set (not always the first one)
        $keys = array_keys($bank);
        return $bank[$keys[crc32($key) % count($keys)]] ?? [];
    }

    public function getBank(string $language): array
    {
        return match ($language) {
            'Dutch' => $this->dutch(),
            'German' => $this->german(),
            'French' => $this->french(),
            'Spanish' => $this->spanish(),
            'Portuguese' => $this->portuguese(),
            'Italian' => $this->italian(),
            'Turkish' => $this->turkish(),
            'Russian' => $this->russian(),
            'Arabic' => $this->arabic(),
            'Japanese' => $this->japanese(),
            'Chinese' => $this->chinese(),
            default => $this->spanish(),
        };
    }

    // ═══════════════════════════════════════════
    //  SPANISH
    // ═══════════════════════════════════════════
    private function spanish(): array
    {
        return [
            // ── MODULE 1: FOUNDATIONS (A1.1) ──
            'greetings' => [
                ['word' => 'hola', 'translation' => 'hello'],
                ['word' => "adi\u{00F3}s", 'translation' => 'goodbye'],
                ['word' => "buenos d\u{00ED}as", 'translation' => 'good morning'],
                ['word' => 'buenas tardes', 'translation' => 'good afternoon'],
                ['word' => 'buenas noches', 'translation' => 'good night'],
                ['word' => 'hasta luego', 'translation' => 'see you later'],
            ],
            'introductions' => [
                ['word' => 'me llamo', 'translation' => 'my name is'],
                ['word' => "\u{00BF}c\u{00F3}mo te llamas?", 'translation' => 'what is your name?'],
                ['word' => 'mucho gusto', 'translation' => 'nice to meet you'],
                ['word' => 'soy de', 'translation' => 'I am from'],
                ['word' => "\u{00BF}c\u{00F3}mo est\u{00E1}s?", 'translation' => 'how are you?'],
                ['word' => 'estoy bien', 'translation' => "I'm fine"],
            ],
            'numbers 1-10' => [
                ['word' => 'uno', 'translation' => 'one'],
                ['word' => 'dos', 'translation' => 'two'],
                ['word' => 'tres', 'translation' => 'three'],
                ['word' => 'cuatro', 'translation' => 'four'],
                ['word' => 'cinco', 'translation' => 'five'],
                ['word' => 'seis', 'translation' => 'six'],
            ],
            'numbers 11-20' => [
                ['word' => 'once', 'translation' => 'eleven'],
                ['word' => 'doce', 'translation' => 'twelve'],
                ['word' => 'trece', 'translation' => 'thirteen'],
                ['word' => 'catorce', 'translation' => 'fourteen'],
                ['word' => 'quince', 'translation' => 'fifteen'],
                ['word' => 'veinte', 'translation' => 'twenty'],
            ],
            'basic phrases' => [
                ['word' => 'por favor', 'translation' => 'please'],
                ['word' => 'gracias', 'translation' => 'thank you'],
                ['word' => 'de nada', 'translation' => "you're welcome"],
                ['word' => 'lo siento', 'translation' => "I'm sorry"],
                ['word' => "\u{00BF}cu\u{00E1}nto cuesta?", 'translation' => 'how much does it cost?'],
                ['word' => 'no entiendo', 'translation' => "I don't understand"],
            ],
            'yes and no' => [
                ['word' => "s\u{00ED}", 'translation' => 'yes'],
                ['word' => 'no', 'translation' => 'no'],
                ['word' => "quiz\u{00E1}s", 'translation' => 'maybe'],
                ['word' => 'por supuesto', 'translation' => 'of course'],
                ['word' => "tambi\u{00E9}n", 'translation' => 'also'],
                ['word' => 'pero', 'translation' => 'but'],
            ],
            'the alphabet' => [
                ['word' => 'a', 'translation' => 'a'],
                ['word' => 'be', 'translation' => 'b'],
                ['word' => 'ce', 'translation' => 'c'],
                ['word' => 'de', 'translation' => 'd'],
                ['word' => "e\u{00F1}e", 'translation' => 'ñ'],
                ['word' => 'hache', 'translation' => 'h'],
            ],

            // ── MODULE 2: PEOPLE & DESCRIPTIONS (A1.2) ──
            'family members' => [
                ['word' => 'madre', 'translation' => 'mother'],
                ['word' => 'padre', 'translation' => 'father'],
                ['word' => 'hermano', 'translation' => 'brother'],
                ['word' => 'hermana', 'translation' => 'sister'],
                ['word' => 'hijo', 'translation' => 'son'],
                ['word' => 'hija', 'translation' => 'daughter'],
            ],
            'more family' => [
                ['word' => 'abuelo', 'translation' => 'grandfather'],
                ['word' => 'abuela', 'translation' => 'grandmother'],
                ['word' => "t\u{00ED}o", 'translation' => 'uncle'],
                ['word' => "t\u{00ED}a", 'translation' => 'aunt'],
                ['word' => 'primo', 'translation' => 'cousin (m)'],
                ['word' => 'prima', 'translation' => 'cousin (f)'],
            ],
            'colors' => [
                ['word' => 'rojo', 'translation' => 'red'],
                ['word' => 'azul', 'translation' => 'blue'],
                ['word' => 'verde', 'translation' => 'green'],
                ['word' => 'amarillo', 'translation' => 'yellow'],
                ['word' => 'blanco', 'translation' => 'white'],
                ['word' => 'negro', 'translation' => 'black'],
            ],
            'more colors' => [
                ['word' => 'naranja', 'translation' => 'orange'],
                ['word' => 'rosa', 'translation' => 'pink'],
                ['word' => 'gris', 'translation' => 'gray'],
                ['word' => "marr\u{00F3}n", 'translation' => 'brown'],
                ['word' => 'morado', 'translation' => 'purple'],
                ['word' => 'dorado', 'translation' => 'gold'],
            ],
            'adjectives' => [
                ['word' => 'grande', 'translation' => 'big'],
                ['word' => "peque\u{00F1}o", 'translation' => 'small'],
                ['word' => 'bueno', 'translation' => 'good'],
                ['word' => 'malo', 'translation' => 'bad'],
                ['word' => 'bonito', 'translation' => 'pretty'],
                ['word' => 'feo', 'translation' => 'ugly'],
            ],
            'more adjectives' => [
                ['word' => "r\u{00E1}pido", 'translation' => 'fast'],
                ['word' => 'lento', 'translation' => 'slow'],
                ['word' => 'nuevo', 'translation' => 'new'],
                ['word' => 'viejo', 'translation' => 'old'],
                ['word' => "f\u{00E1}cil", 'translation' => 'easy'],
                ['word' => "dif\u{00ED}cil", 'translation' => 'difficult'],
            ],
            'describing people' => [
                ['word' => 'alto', 'translation' => 'tall'],
                ['word' => 'bajo', 'translation' => 'short'],
                ['word' => 'joven', 'translation' => 'young'],
                ['word' => 'fuerte', 'translation' => 'strong'],
                ['word' => 'delgado', 'translation' => 'thin'],
                ['word' => 'guapo', 'translation' => 'handsome'],
            ],

            // ── MODULE 3: DAILY LIFE (A1.3) ──
            'food basics' => [
                ['word' => 'agua', 'translation' => 'water'],
                ['word' => 'pan', 'translation' => 'bread'],
                ['word' => 'leche', 'translation' => 'milk'],
                ['word' => "caf\u{00E9}", 'translation' => 'coffee'],
                ['word' => 'fruta', 'translation' => 'fruit'],
                ['word' => 'carne', 'translation' => 'meat'],
            ],
            'more food' => [
                ['word' => 'arroz', 'translation' => 'rice'],
                ['word' => 'pollo', 'translation' => 'chicken'],
                ['word' => 'pescado', 'translation' => 'fish'],
                ['word' => 'huevo', 'translation' => 'egg'],
                ['word' => 'queso', 'translation' => 'cheese'],
                ['word' => 'ensalada', 'translation' => 'salad'],
            ],
            'fruits' => [
                ['word' => 'manzana', 'translation' => 'apple'],
                ['word' => "pl\u{00E1}tano", 'translation' => 'banana'],
                ['word' => 'naranja', 'translation' => 'orange'],
                ['word' => 'fresa', 'translation' => 'strawberry'],
                ['word' => 'uva', 'translation' => 'grape'],
                ['word' => "lim\u{00F3}n", 'translation' => 'lemon'],
            ],
            'drinks' => [
                ['word' => "t\u{00E9}", 'translation' => 'tea'],
                ['word' => 'cerveza', 'translation' => 'beer'],
                ['word' => 'vino', 'translation' => 'wine'],
                ['word' => 'zumo', 'translation' => 'juice'],
                ['word' => 'refresco', 'translation' => 'soda'],
                ['word' => 'agua con gas', 'translation' => 'sparkling water'],
            ],
            'at the restaurant' => [
                ['word' => 'la cuenta', 'translation' => 'the bill'],
                ['word' => 'el menú', 'translation' => 'the menu'],
                ['word' => 'camarero', 'translation' => 'waiter'],
                ['word' => 'propina', 'translation' => 'tip'],
                ['word' => 'mesa', 'translation' => 'table'],
                ['word' => "reservaci\u{00F3}n", 'translation' => 'reservation'],
            ],
            'meals' => [
                ['word' => 'desayuno', 'translation' => 'breakfast'],
                ['word' => 'almuerzo', 'translation' => 'lunch'],
                ['word' => 'cena', 'translation' => 'dinner'],
                ['word' => 'merienda', 'translation' => 'snack'],
                ['word' => 'tengo hambre', 'translation' => "I'm hungry"],
                ['word' => 'tengo sed', 'translation' => "I'm thirsty"],
            ],

            // ── MODULE 4: HOME & ROUTINE (A2.1) ──
            'the house' => [
                ['word' => 'casa', 'translation' => 'house'],
                ['word' => "habitaci\u{00F3}n", 'translation' => 'room'],
                ['word' => 'cocina', 'translation' => 'kitchen'],
                ['word' => "ba\u{00F1}o", 'translation' => 'bathroom'],
                ['word' => "sal\u{00F3}n", 'translation' => 'living room'],
                ['word' => 'dormitorio', 'translation' => 'bedroom'],
            ],
            'furniture' => [
                ['word' => 'silla', 'translation' => 'chair'],
                ['word' => 'mesa', 'translation' => 'table'],
                ['word' => 'cama', 'translation' => 'bed'],
                ['word' => 'puerta', 'translation' => 'door'],
                ['word' => 'ventana', 'translation' => 'window'],
                ['word' => 'armario', 'translation' => 'wardrobe'],
            ],
            'daily routine' => [
                ['word' => 'despertarse', 'translation' => 'to wake up'],
                ['word' => 'ducharse', 'translation' => 'to shower'],
                ['word' => 'vestirse', 'translation' => 'to get dressed'],
                ['word' => 'trabajar', 'translation' => 'to work'],
                ['word' => 'comer', 'translation' => 'to eat'],
                ['word' => 'dormir', 'translation' => 'to sleep'],
            ],
            'telling time' => [
                ['word' => "\u{00BF}qu\u{00E9} hora es?", 'translation' => 'what time is it?'],
                ['word' => 'la una', 'translation' => 'one o\'clock'],
                ['word' => 'las dos', 'translation' => 'two o\'clock'],
                ['word' => 'medianoche', 'translation' => 'midnight'],
                ['word' => "mediod\u{00ED}a", 'translation' => 'noon'],
                ['word' => 'y media', 'translation' => 'half past'],
            ],
            'days of the week' => [
                ['word' => 'lunes', 'translation' => 'Monday'],
                ['word' => 'martes', 'translation' => 'Tuesday'],
                ['word' => "mi\u{00E9}rcoles", 'translation' => 'Wednesday'],
                ['word' => 'jueves', 'translation' => 'Thursday'],
                ['word' => 'viernes', 'translation' => 'Friday'],
                ['word' => "s\u{00E1}bado", 'translation' => 'Saturday'],
            ],
            'months' => [
                ['word' => 'enero', 'translation' => 'January'],
                ['word' => 'febrero', 'translation' => 'February'],
                ['word' => 'marzo', 'translation' => 'March'],
                ['word' => 'abril', 'translation' => 'April'],
                ['word' => 'mayo', 'translation' => 'May'],
                ['word' => 'junio', 'translation' => 'June'],
            ],

            // ── MODULE 5: GETTING AROUND (A2.2) ──
            'weather' => [
                ['word' => 'sol', 'translation' => 'sun'],
                ['word' => 'lluvia', 'translation' => 'rain'],
                ['word' => 'nieve', 'translation' => 'snow'],
                ['word' => 'viento', 'translation' => 'wind'],
                ['word' => 'nublado', 'translation' => 'cloudy'],
                ['word' => 'hace calor', 'translation' => "it's hot"],
            ],
            'seasons' => [
                ['word' => 'primavera', 'translation' => 'spring'],
                ['word' => 'verano', 'translation' => 'summer'],
                ['word' => "oto\u{00F1}o", 'translation' => 'autumn'],
                ['word' => 'invierno', 'translation' => 'winter'],
                ['word' => "estaci\u{00F3}n", 'translation' => 'season'],
                ['word' => 'temperatura', 'translation' => 'temperature'],
            ],
            'directions' => [
                ['word' => 'izquierda', 'translation' => 'left'],
                ['word' => 'derecha', 'translation' => 'right'],
                ['word' => 'recto', 'translation' => 'straight'],
                ['word' => 'cerca', 'translation' => 'near'],
                ['word' => 'lejos', 'translation' => 'far'],
                ['word' => 'esquina', 'translation' => 'corner'],
            ],
            'places in town' => [
                ['word' => 'calle', 'translation' => 'street'],
                ['word' => 'plaza', 'translation' => 'square'],
                ['word' => 'parque', 'translation' => 'park'],
                ['word' => 'tienda', 'translation' => 'shop'],
                ['word' => 'banco', 'translation' => 'bank'],
                ['word' => 'hospital', 'translation' => 'hospital'],
            ],
            'transport' => [
                ['word' => 'coche', 'translation' => 'car'],
                ['word' => "autob\u{00FA}s", 'translation' => 'bus'],
                ['word' => 'tren', 'translation' => 'train'],
                ['word' => "avi\u{00F3}n", 'translation' => 'airplane'],
                ['word' => 'bicicleta', 'translation' => 'bicycle'],
                ['word' => 'taxi', 'translation' => 'taxi'],
            ],
            'at the station' => [
                ['word' => 'billete', 'translation' => 'ticket'],
                ['word' => "estaci\u{00F3}n", 'translation' => 'station'],
                ['word' => "and\u{00E9}n", 'translation' => 'platform'],
                ['word' => 'salida', 'translation' => 'departure'],
                ['word' => 'llegada', 'translation' => 'arrival'],
                ['word' => 'horario', 'translation' => 'schedule'],
            ],
            'shopping basics' => [
                ['word' => 'comprar', 'translation' => 'to buy'],
                ['word' => 'vender', 'translation' => 'to sell'],
                ['word' => 'precio', 'translation' => 'price'],
                ['word' => 'barato', 'translation' => 'cheap'],
                ['word' => 'caro', 'translation' => 'expensive'],
                ['word' => 'dinero', 'translation' => 'money'],
            ],

            // ── MODULE 6: BODY & HEALTH (B1.1) ──
            'body parts' => [
                ['word' => 'cabeza', 'translation' => 'head'],
                ['word' => 'mano', 'translation' => 'hand'],
                ['word' => 'pie', 'translation' => 'foot'],
                ['word' => 'ojo', 'translation' => 'eye'],
                ['word' => 'boca', 'translation' => 'mouth'],
                ['word' => "coraz\u{00F3}n", 'translation' => 'heart'],
            ],
            'more body parts' => [
                ['word' => 'brazo', 'translation' => 'arm'],
                ['word' => 'pierna', 'translation' => 'leg'],
                ['word' => 'dedo', 'translation' => 'finger'],
                ['word' => 'espalda', 'translation' => 'back'],
                ['word' => "est\u{00F3}mago", 'translation' => 'stomach'],
                ['word' => 'oreja', 'translation' => 'ear'],
            ],
            'at the doctor' => [
                ['word' => "m\u{00E9}dico", 'translation' => 'doctor'],
                ['word' => 'enfermo', 'translation' => 'sick'],
                ['word' => 'dolor', 'translation' => 'pain'],
                ['word' => 'fiebre', 'translation' => 'fever'],
                ['word' => 'medicina', 'translation' => 'medicine'],
                ['word' => 'farmacia', 'translation' => 'pharmacy'],
            ],
            'feelings' => [
                ['word' => 'feliz', 'translation' => 'happy'],
                ['word' => 'triste', 'translation' => 'sad'],
                ['word' => 'cansado', 'translation' => 'tired'],
                ['word' => 'enojado', 'translation' => 'angry'],
                ['word' => 'nervioso', 'translation' => 'nervous'],
                ['word' => 'tranquilo', 'translation' => 'calm'],
            ],
            'emotions' => [
                ['word' => 'amor', 'translation' => 'love'],
                ['word' => 'miedo', 'translation' => 'fear'],
                ['word' => "alegr\u{00ED}a", 'translation' => 'joy'],
                ['word' => 'sorpresa', 'translation' => 'surprise'],
                ['word' => 'esperanza', 'translation' => 'hope'],
                ['word' => "pasi\u{00F3}n", 'translation' => 'passion'],
            ],

            // ── MODULE 7: HOBBIES & SOCIAL (B1.2) ──
            'hobbies' => [
                ['word' => 'leer', 'translation' => 'to read'],
                ['word' => 'escribir', 'translation' => 'to write'],
                ['word' => 'cocinar', 'translation' => 'to cook'],
                ['word' => 'bailar', 'translation' => 'to dance'],
                ['word' => 'cantar', 'translation' => 'to sing'],
                ['word' => 'nadar', 'translation' => 'to swim'],
            ],
            'sports' => [
                ['word' => "f\u{00FA}tbol", 'translation' => 'football'],
                ['word' => 'baloncesto', 'translation' => 'basketball'],
                ['word' => 'tenis', 'translation' => 'tennis'],
                ['word' => 'correr', 'translation' => 'to run'],
                ['word' => 'gimnasio', 'translation' => 'gym'],
                ['word' => 'equipo', 'translation' => 'team'],
            ],
            'music and art' => [
                ['word' => "m\u{00FA}sica", 'translation' => 'music'],
                ['word' => "canci\u{00F3}n", 'translation' => 'song'],
                ['word' => 'pintura', 'translation' => 'painting'],
                ['word' => "pel\u{00ED}cula", 'translation' => 'movie'],
                ['word' => 'libro', 'translation' => 'book'],
                ['word' => 'teatro', 'translation' => 'theater'],
            ],
            'technology' => [
                ['word' => "tel\u{00E9}fono", 'translation' => 'phone'],
                ['word' => 'ordenador', 'translation' => 'computer'],
                ['word' => 'internet', 'translation' => 'internet'],
                ['word' => "contrase\u{00F1}a", 'translation' => 'password'],
                ['word' => 'mensaje', 'translation' => 'message'],
                ['word' => 'pantalla', 'translation' => 'screen'],
            ],
            'making plans' => [
                ['word' => "\u{00BF}quieres venir?", 'translation' => 'do you want to come?'],
                ['word' => 'vamos a', 'translation' => "let's go to"],
                ['word' => 'esta noche', 'translation' => 'tonight'],
                ['word' => 'el fin de semana', 'translation' => 'the weekend'],
                ['word' => "ma\u{00F1}ana", 'translation' => 'tomorrow'],
                ['word' => 'la fiesta', 'translation' => 'the party'],
            ],

            // ── MODULE 8: TRAVEL (B1.3) ──
            'at the airport' => [
                ['word' => 'vuelo', 'translation' => 'flight'],
                ['word' => 'pasaporte', 'translation' => 'passport'],
                ['word' => 'equipaje', 'translation' => 'luggage'],
                ['word' => 'puerta de embarque', 'translation' => 'boarding gate'],
                ['word' => 'despegar', 'translation' => 'to take off'],
                ['word' => 'aterrizar', 'translation' => 'to land'],
            ],
            'at the hotel' => [
                ['word' => "habitaci\u{00F3}n", 'translation' => 'room'],
                ['word' => 'reserva', 'translation' => 'reservation'],
                ['word' => 'llave', 'translation' => 'key'],
                ['word' => "recepci\u{00F3}n", 'translation' => 'reception'],
                ['word' => 'piscina', 'translation' => 'pool'],
                ['word' => 'desayuno incluido', 'translation' => 'breakfast included'],
            ],
            'sightseeing' => [
                ['word' => 'museo', 'translation' => 'museum'],
                ['word' => 'iglesia', 'translation' => 'church'],
                ['word' => 'playa', 'translation' => 'beach'],
                ['word' => "monta\u{00F1}a", 'translation' => 'mountain'],
                ['word' => 'castillo', 'translation' => 'castle'],
                ['word' => 'monumento', 'translation' => 'monument'],
            ],
            'emergencies' => [
                ['word' => 'ayuda', 'translation' => 'help'],
                ['word' => "polic\u{00ED}a", 'translation' => 'police'],
                ['word' => 'emergencia', 'translation' => 'emergency'],
                ['word' => 'ambulancia', 'translation' => 'ambulance'],
                ['word' => 'estoy perdido', 'translation' => "I'm lost"],
                ['word' => 'peligro', 'translation' => 'danger'],
            ],
            'booking' => [
                ['word' => 'reservar', 'translation' => 'to book'],
                ['word' => 'cancelar', 'translation' => 'to cancel'],
                ['word' => 'confirmar', 'translation' => 'to confirm'],
                ['word' => 'disponible', 'translation' => 'available'],
                ['word' => 'fecha', 'translation' => 'date'],
                ['word' => 'noche', 'translation' => 'night'],
            ],

            // ── MODULE 9: WORK & STUDY (B1.4) ──
            'at school' => [
                ['word' => 'escuela', 'translation' => 'school'],
                ['word' => 'profesor', 'translation' => 'teacher'],
                ['word' => 'alumno', 'translation' => 'student'],
                ['word' => 'clase', 'translation' => 'class'],
                ['word' => 'examen', 'translation' => 'exam'],
                ['word' => 'tarea', 'translation' => 'homework'],
            ],
            'at the office' => [
                ['word' => 'oficina', 'translation' => 'office'],
                ['word' => "reuni\u{00F3}n", 'translation' => 'meeting'],
                ['word' => 'jefe', 'translation' => 'boss'],
                ['word' => 'proyecto', 'translation' => 'project'],
                ['word' => 'correo', 'translation' => 'email'],
                ['word' => 'plazo', 'translation' => 'deadline'],
            ],
            'professions' => [
                ['word' => "m\u{00E9}dico", 'translation' => 'doctor'],
                ['word' => 'abogado', 'translation' => 'lawyer'],
                ['word' => 'ingeniero', 'translation' => 'engineer'],
                ['word' => 'enfermero', 'translation' => 'nurse'],
                ['word' => 'cocinero', 'translation' => 'cook'],
                ['word' => 'periodista', 'translation' => 'journalist'],
            ],

            // ── MODULE 10: VERBS & GRAMMAR (B1.5) ──
            'common verbs 1' => [
                ['word' => 'ser', 'translation' => 'to be (permanent)'],
                ['word' => 'estar', 'translation' => 'to be (temporary)'],
                ['word' => 'tener', 'translation' => 'to have'],
                ['word' => 'hacer', 'translation' => 'to do / to make'],
                ['word' => 'ir', 'translation' => 'to go'],
                ['word' => 'venir', 'translation' => 'to come'],
            ],
            'common verbs 2' => [
                ['word' => 'querer', 'translation' => 'to want'],
                ['word' => 'poder', 'translation' => 'to be able to'],
                ['word' => 'saber', 'translation' => 'to know (fact)'],
                ['word' => 'conocer', 'translation' => 'to know (person)'],
                ['word' => 'hablar', 'translation' => 'to speak'],
                ['word' => 'entender', 'translation' => 'to understand'],
            ],
            'common verbs 3' => [
                ['word' => 'dar', 'translation' => 'to give'],
                ['word' => 'poner', 'translation' => 'to put'],
                ['word' => 'salir', 'translation' => 'to leave'],
                ['word' => 'llegar', 'translation' => 'to arrive'],
                ['word' => 'pensar', 'translation' => 'to think'],
                ['word' => 'creer', 'translation' => 'to believe'],
            ],
            'past tense basics' => [
                ['word' => "habl\u{00E9}", 'translation' => 'I spoke'],
                ['word' => "com\u{00ED}", 'translation' => 'I ate'],
                ['word' => "viv\u{00ED}", 'translation' => 'I lived'],
                ['word' => 'fui', 'translation' => 'I went / I was'],
                ['word' => 'tuve', 'translation' => 'I had'],
                ['word' => 'hice', 'translation' => 'I did / I made'],
            ],
            'future tense' => [
                ['word' => "hablar\u{00E9}", 'translation' => 'I will speak'],
                ['word' => "comer\u{00E9}", 'translation' => 'I will eat'],
                ['word' => "ir\u{00E9}", 'translation' => 'I will go'],
                ['word' => "ser\u{00E9}", 'translation' => 'I will be'],
                ['word' => "tendr\u{00E9}", 'translation' => 'I will have'],
                ['word' => "har\u{00E9}", 'translation' => 'I will do'],
            ],
            'clothing' => [
                ['word' => 'camisa', 'translation' => 'shirt'],
                ['word' => "pantal\u{00F3}n", 'translation' => 'pants'],
                ['word' => 'zapatos', 'translation' => 'shoes'],
                ['word' => 'vestido', 'translation' => 'dress'],
                ['word' => 'chaqueta', 'translation' => 'jacket'],
                ['word' => 'sombrero', 'translation' => 'hat'],
            ],
            'nature' => [
                ['word' => "\u{00E1}rbol", 'translation' => 'tree'],
                ['word' => 'flor', 'translation' => 'flower'],
                ['word' => 'mar', 'translation' => 'sea'],
                ['word' => "r\u{00ED}o", 'translation' => 'river'],
                ['word' => 'bosque', 'translation' => 'forest'],
                ['word' => 'cielo', 'translation' => 'sky'],
            ],
            'animals' => [
                ['word' => 'perro', 'translation' => 'dog'],
                ['word' => 'gato', 'translation' => 'cat'],
                ['word' => "p\u{00E1}jaro", 'translation' => 'bird'],
                ['word' => 'caballo', 'translation' => 'horse'],
                ['word' => 'pez', 'translation' => 'fish'],
                ['word' => 'mariposa', 'translation' => 'butterfly'],
            ],
            'opinions' => [
                ['word' => 'me gusta', 'translation' => 'I like'],
                ['word' => 'no me gusta', 'translation' => "I don't like"],
                ['word' => 'me encanta', 'translation' => 'I love'],
                ['word' => 'prefiero', 'translation' => 'I prefer'],
                ['word' => 'creo que', 'translation' => 'I think that'],
                ['word' => 'en mi opini\u{00F3}n', 'translation' => 'in my opinion'],
            ],
            'conversation phrases' => [
                ['word' => "\u{00BF}qu\u{00E9} tal?", 'translation' => "how's it going?"],
                ['word' => 'claro', 'translation' => 'of course'],
                ['word' => 'vale', 'translation' => 'okay'],
                ['word' => 'genial', 'translation' => 'great'],
                ['word' => "no te preocupes", 'translation' => "don't worry"],
                ['word' => "\u{00BF}en serio?", 'translation' => 'seriously?'],
            ],
        ];
    }

    // ═══════════════════════════════════════════
    //  FRENCH — abbreviated, same structure
    // ═══════════════════════════════════════════
    private function french(): array
    {
        return [
            'greetings' => [
                ['word' => 'bonjour', 'translation' => 'hello'],
                ['word' => 'au revoir', 'translation' => 'goodbye'],
                ['word' => 'bonsoir', 'translation' => 'good evening'],
                ['word' => 'bonne nuit', 'translation' => 'good night'],
                ['word' => "salut", 'translation' => 'hi / bye'],
                ['word' => "\u{00E0} bient\u{00F4}t", 'translation' => 'see you soon'],
            ],
            'introductions' => [
                ['word' => "je m'appelle", 'translation' => 'my name is'],
                ['word' => "comment tu t'appelles?", 'translation' => 'what is your name?'],
                ['word' => "enchant\u{00E9}", 'translation' => 'nice to meet you'],
                ['word' => 'je suis de', 'translation' => 'I am from'],
                ['word' => 'comment allez-vous?', 'translation' => 'how are you?'],
                ['word' => "je vais bien", 'translation' => "I'm doing well"],
            ],
            'numbers 1-10' => [
                ['word' => 'un', 'translation' => 'one'],
                ['word' => 'deux', 'translation' => 'two'],
                ['word' => 'trois', 'translation' => 'three'],
                ['word' => 'quatre', 'translation' => 'four'],
                ['word' => 'cinq', 'translation' => 'five'],
                ['word' => 'six', 'translation' => 'six'],
            ],
            'numbers 11-20' => [
                ['word' => 'onze', 'translation' => 'eleven'],
                ['word' => 'douze', 'translation' => 'twelve'],
                ['word' => 'treize', 'translation' => 'thirteen'],
                ['word' => 'quatorze', 'translation' => 'fourteen'],
                ['word' => 'quinze', 'translation' => 'fifteen'],
                ['word' => 'vingt', 'translation' => 'twenty'],
            ],
            'basic phrases' => [
                ['word' => "s'il vous pla\u{00EE}t", 'translation' => 'please'],
                ['word' => 'merci', 'translation' => 'thank you'],
                ['word' => 'de rien', 'translation' => "you're welcome"],
                ['word' => "d\u{00E9}sol\u{00E9}", 'translation' => "I'm sorry"],
                ['word' => 'excusez-moi', 'translation' => 'excuse me'],
                ['word' => 'je ne comprends pas', 'translation' => "I don't understand"],
            ],
            'yes and no' => [
                ['word' => 'oui', 'translation' => 'yes'],
                ['word' => 'non', 'translation' => 'no'],
                ['word' => "peut-\u{00EA}tre", 'translation' => 'maybe'],
                ['word' => 'bien s\u{00FB}r', 'translation' => 'of course'],
                ['word' => 'aussi', 'translation' => 'also'],
                ['word' => 'mais', 'translation' => 'but'],
            ],
            'family members' => [
                ['word' => "m\u{00E8}re", 'translation' => 'mother'],
                ['word' => "p\u{00E8}re", 'translation' => 'father'],
                ['word' => "fr\u{00E8}re", 'translation' => 'brother'],
                ['word' => 'soeur', 'translation' => 'sister'],
                ['word' => 'fils', 'translation' => 'son'],
                ['word' => 'fille', 'translation' => 'daughter'],
            ],
            'colors' => [
                ['word' => 'rouge', 'translation' => 'red'],
                ['word' => 'bleu', 'translation' => 'blue'],
                ['word' => 'vert', 'translation' => 'green'],
                ['word' => 'jaune', 'translation' => 'yellow'],
                ['word' => 'blanc', 'translation' => 'white'],
                ['word' => 'noir', 'translation' => 'black'],
            ],
            'food basics' => [
                ['word' => 'eau', 'translation' => 'water'],
                ['word' => 'pain', 'translation' => 'bread'],
                ['word' => 'lait', 'translation' => 'milk'],
                ['word' => "caf\u{00E9}", 'translation' => 'coffee'],
                ['word' => 'fromage', 'translation' => 'cheese'],
                ['word' => 'viande', 'translation' => 'meat'],
            ],
            'more food' => [
                ['word' => 'riz', 'translation' => 'rice'],
                ['word' => 'poulet', 'translation' => 'chicken'],
                ['word' => 'poisson', 'translation' => 'fish'],
                ['word' => 'oeuf', 'translation' => 'egg'],
                ['word' => 'salade', 'translation' => 'salad'],
                ['word' => 'soupe', 'translation' => 'soup'],
            ],
            'the house' => [
                ['word' => 'maison', 'translation' => 'house'],
                ['word' => 'chambre', 'translation' => 'room'],
                ['word' => 'cuisine', 'translation' => 'kitchen'],
                ['word' => 'salle de bain', 'translation' => 'bathroom'],
                ['word' => 'salon', 'translation' => 'living room'],
                ['word' => 'jardin', 'translation' => 'garden'],
            ],
            'daily routine' => [
                ['word' => 'se r\u{00E9}veiller', 'translation' => 'to wake up'],
                ['word' => 'se doucher', 'translation' => 'to shower'],
                ['word' => "s'habiller", 'translation' => 'to get dressed'],
                ['word' => 'travailler', 'translation' => 'to work'],
                ['word' => 'manger', 'translation' => 'to eat'],
                ['word' => 'dormir', 'translation' => 'to sleep'],
            ],
            'days of the week' => [
                ['word' => 'lundi', 'translation' => 'Monday'],
                ['word' => 'mardi', 'translation' => 'Tuesday'],
                ['word' => 'mercredi', 'translation' => 'Wednesday'],
                ['word' => 'jeudi', 'translation' => 'Thursday'],
                ['word' => 'vendredi', 'translation' => 'Friday'],
                ['word' => 'samedi', 'translation' => 'Saturday'],
            ],
            'weather' => [
                ['word' => 'soleil', 'translation' => 'sun'],
                ['word' => 'pluie', 'translation' => 'rain'],
                ['word' => 'neige', 'translation' => 'snow'],
                ['word' => 'vent', 'translation' => 'wind'],
                ['word' => 'nuageux', 'translation' => 'cloudy'],
                ['word' => 'il fait chaud', 'translation' => "it's hot"],
            ],
            'transport' => [
                ['word' => 'voiture', 'translation' => 'car'],
                ['word' => 'bus', 'translation' => 'bus'],
                ['word' => 'train', 'translation' => 'train'],
                ['word' => 'avion', 'translation' => 'airplane'],
                ['word' => "v\u{00E9}lo", 'translation' => 'bicycle'],
                ['word' => "m\u{00E9}tro", 'translation' => 'metro'],
            ],
            'body parts' => [
                ['word' => "t\u{00EA}te", 'translation' => 'head'],
                ['word' => 'main', 'translation' => 'hand'],
                ['word' => 'pied', 'translation' => 'foot'],
                ['word' => 'oeil', 'translation' => 'eye'],
                ['word' => 'bouche', 'translation' => 'mouth'],
                ['word' => 'coeur', 'translation' => 'heart'],
            ],
            'feelings' => [
                ['word' => 'heureux', 'translation' => 'happy'],
                ['word' => 'triste', 'translation' => 'sad'],
                ['word' => "fatigu\u{00E9}", 'translation' => 'tired'],
                ['word' => "f\u{00E2}ch\u{00E9}", 'translation' => 'angry'],
                ['word' => 'nerveux', 'translation' => 'nervous'],
                ['word' => 'calme', 'translation' => 'calm'],
            ],
            'hobbies' => [
                ['word' => 'lire', 'translation' => 'to read'],
                ['word' => "\u{00E9}crire", 'translation' => 'to write'],
                ['word' => 'cuisiner', 'translation' => 'to cook'],
                ['word' => 'danser', 'translation' => 'to dance'],
                ['word' => 'chanter', 'translation' => 'to sing'],
                ['word' => 'nager', 'translation' => 'to swim'],
            ],
            'at the restaurant' => [
                ['word' => "l'addition", 'translation' => 'the bill'],
                ['word' => 'le menu', 'translation' => 'the menu'],
                ['word' => 'serveur', 'translation' => 'waiter'],
                ['word' => 'pourboire', 'translation' => 'tip'],
                ['word' => 'table', 'translation' => 'table'],
                ['word' => "r\u{00E9}servation", 'translation' => 'reservation'],
            ],
            'professions' => [
                ['word' => "m\u{00E9}decin", 'translation' => 'doctor'],
                ['word' => 'avocat', 'translation' => 'lawyer'],
                ['word' => "ing\u{00E9}nieur", 'translation' => 'engineer'],
                ['word' => "infirmi\u{00E8}re", 'translation' => 'nurse'],
                ['word' => 'cuisinier', 'translation' => 'cook'],
                ['word' => 'professeur', 'translation' => 'teacher'],
            ],
            'common verbs' => [
                ['word' => "\u{00EA}tre", 'translation' => 'to be'],
                ['word' => 'avoir', 'translation' => 'to have'],
                ['word' => 'faire', 'translation' => 'to do / to make'],
                ['word' => 'aller', 'translation' => 'to go'],
                ['word' => 'venir', 'translation' => 'to come'],
                ['word' => 'vouloir', 'translation' => 'to want'],
            ],
            'animals' => [
                ['word' => 'chien', 'translation' => 'dog'],
                ['word' => 'chat', 'translation' => 'cat'],
                ['word' => 'oiseau', 'translation' => 'bird'],
                ['word' => 'cheval', 'translation' => 'horse'],
                ['word' => 'poisson', 'translation' => 'fish'],
                ['word' => 'papillon', 'translation' => 'butterfly'],
            ],
            'nature' => [
                ['word' => 'arbre', 'translation' => 'tree'],
                ['word' => 'fleur', 'translation' => 'flower'],
                ['word' => 'mer', 'translation' => 'sea'],
                ['word' => "rivi\u{00E8}re", 'translation' => 'river'],
                ['word' => "for\u{00EA}t", 'translation' => 'forest'],
                ['word' => 'ciel', 'translation' => 'sky'],
            ],
        ];
    }

    // Other languages return a smaller but functional bank
    private function german(): array
    {
        return [
            'greetings' => [
                ['word' => 'hallo', 'translation' => 'hello'],
                ['word' => "tsch\u{00FC}ss", 'translation' => 'goodbye'],
                ['word' => 'guten Morgen', 'translation' => 'good morning'],
                ['word' => 'guten Tag', 'translation' => 'good day'],
                ['word' => 'gute Nacht', 'translation' => 'good night'],
                ['word' => "bis sp\u{00E4}ter", 'translation' => 'see you later'],
            ],
            'introductions' => [
                ['word' => "ich hei\u{00DF}e", 'translation' => 'my name is'],
                ['word' => "wie hei\u{00DF}t du?", 'translation' => 'what is your name?'],
                ['word' => 'freut mich', 'translation' => 'nice to meet you'],
                ['word' => 'ich komme aus', 'translation' => 'I come from'],
                ['word' => 'wie geht es dir?', 'translation' => 'how are you?'],
                ['word' => 'mir geht es gut', 'translation' => "I'm doing well"],
            ],
            'numbers 1-10' => [
                ['word' => 'eins', 'translation' => 'one'],
                ['word' => 'zwei', 'translation' => 'two'],
                ['word' => 'drei', 'translation' => 'three'],
                ['word' => 'vier', 'translation' => 'four'],
                ['word' => "f\u{00FC}nf", 'translation' => 'five'],
                ['word' => 'sechs', 'translation' => 'six'],
            ],
            'basic phrases' => [
                ['word' => 'bitte', 'translation' => 'please'],
                ['word' => 'danke', 'translation' => 'thank you'],
                ['word' => 'gerne', 'translation' => "you're welcome"],
                ['word' => 'Entschuldigung', 'translation' => "I'm sorry"],
                ['word' => 'ja', 'translation' => 'yes'],
                ['word' => 'nein', 'translation' => 'no'],
            ],
            'family members' => [
                ['word' => 'Mutter', 'translation' => 'mother'],
                ['word' => 'Vater', 'translation' => 'father'],
                ['word' => 'Bruder', 'translation' => 'brother'],
                ['word' => 'Schwester', 'translation' => 'sister'],
                ['word' => 'Sohn', 'translation' => 'son'],
                ['word' => 'Tochter', 'translation' => 'daughter'],
            ],
            'colors' => [
                ['word' => 'rot', 'translation' => 'red'],
                ['word' => 'blau', 'translation' => 'blue'],
                ['word' => "gr\u{00FC}n", 'translation' => 'green'],
                ['word' => 'gelb', 'translation' => 'yellow'],
                ['word' => "wei\u{00DF}", 'translation' => 'white'],
                ['word' => 'schwarz', 'translation' => 'black'],
            ],
            'food basics' => [
                ['word' => 'Wasser', 'translation' => 'water'],
                ['word' => 'Brot', 'translation' => 'bread'],
                ['word' => 'Milch', 'translation' => 'milk'],
                ['word' => 'Kaffee', 'translation' => 'coffee'],
                ['word' => "K\u{00E4}se", 'translation' => 'cheese'],
                ['word' => 'Fleisch', 'translation' => 'meat'],
            ],
            'the house' => [
                ['word' => 'Haus', 'translation' => 'house'],
                ['word' => 'Zimmer', 'translation' => 'room'],
                ['word' => "K\u{00FC}che", 'translation' => 'kitchen'],
                ['word' => 'Badezimmer', 'translation' => 'bathroom'],
                ['word' => 'Wohnzimmer', 'translation' => 'living room'],
                ['word' => 'Schlafzimmer', 'translation' => 'bedroom'],
            ],
            'daily routine' => [
                ['word' => 'aufwachen', 'translation' => 'to wake up'],
                ['word' => 'duschen', 'translation' => 'to shower'],
                ['word' => 'anziehen', 'translation' => 'to get dressed'],
                ['word' => 'arbeiten', 'translation' => 'to work'],
                ['word' => 'essen', 'translation' => 'to eat'],
                ['word' => 'schlafen', 'translation' => 'to sleep'],
            ],
            'days of the week' => [
                ['word' => 'Montag', 'translation' => 'Monday'],
                ['word' => 'Dienstag', 'translation' => 'Tuesday'],
                ['word' => 'Mittwoch', 'translation' => 'Wednesday'],
                ['word' => 'Donnerstag', 'translation' => 'Thursday'],
                ['word' => 'Freitag', 'translation' => 'Friday'],
                ['word' => 'Samstag', 'translation' => 'Saturday'],
            ],
            'weather' => [
                ['word' => 'Sonne', 'translation' => 'sun'],
                ['word' => 'Regen', 'translation' => 'rain'],
                ['word' => 'Schnee', 'translation' => 'snow'],
                ['word' => 'Wind', 'translation' => 'wind'],
                ['word' => "bew\u{00F6}lkt", 'translation' => 'cloudy'],
                ['word' => "es ist hei\u{00DF}", 'translation' => "it's hot"],
            ],
            'transport' => [
                ['word' => 'Auto', 'translation' => 'car'],
                ['word' => 'Bus', 'translation' => 'bus'],
                ['word' => 'Zug', 'translation' => 'train'],
                ['word' => 'Flugzeug', 'translation' => 'airplane'],
                ['word' => 'Fahrrad', 'translation' => 'bicycle'],
                ['word' => 'U-Bahn', 'translation' => 'metro'],
            ],
            'feelings' => [
                ['word' => "gl\u{00FC}cklich", 'translation' => 'happy'],
                ['word' => 'traurig', 'translation' => 'sad'],
                ['word' => "m\u{00FC}de", 'translation' => 'tired'],
                ['word' => "w\u{00FC}tend", 'translation' => 'angry'],
                ['word' => "nerv\u{00F6}s", 'translation' => 'nervous'],
                ['word' => 'ruhig', 'translation' => 'calm'],
            ],
            'common verbs' => [
                ['word' => 'sein', 'translation' => 'to be'],
                ['word' => 'haben', 'translation' => 'to have'],
                ['word' => 'machen', 'translation' => 'to do / to make'],
                ['word' => 'gehen', 'translation' => 'to go'],
                ['word' => 'kommen', 'translation' => 'to come'],
                ['word' => 'wollen', 'translation' => 'to want'],
            ],
            'animals' => [
                ['word' => 'Hund', 'translation' => 'dog'],
                ['word' => 'Katze', 'translation' => 'cat'],
                ['word' => 'Vogel', 'translation' => 'bird'],
                ['word' => 'Pferd', 'translation' => 'horse'],
                ['word' => 'Fisch', 'translation' => 'fish'],
                ['word' => 'Schmetterling', 'translation' => 'butterfly'],
            ],
        ];
    }

    private function italian(): array
    {
        return [
            'greetings' => [
                ['word' => 'ciao', 'translation' => 'hello / bye'],
                ['word' => 'arrivederci', 'translation' => 'goodbye'],
                ['word' => 'buongiorno', 'translation' => 'good morning'],
                ['word' => 'buonasera', 'translation' => 'good evening'],
                ['word' => 'buonanotte', 'translation' => 'good night'],
                ['word' => 'a presto', 'translation' => 'see you soon'],
            ],
            'introductions' => [
                ['word' => 'mi chiamo', 'translation' => 'my name is'],
                ['word' => 'come ti chiami?', 'translation' => 'what is your name?'],
                ['word' => 'piacere', 'translation' => 'nice to meet you'],
                ['word' => 'sono di', 'translation' => 'I am from'],
                ['word' => 'come stai?', 'translation' => 'how are you?'],
                ['word' => 'sto bene', 'translation' => "I'm fine"],
            ],
            'numbers 1-10' => [
                ['word' => 'uno', 'translation' => 'one'],
                ['word' => 'due', 'translation' => 'two'],
                ['word' => 'tre', 'translation' => 'three'],
                ['word' => 'quattro', 'translation' => 'four'],
                ['word' => 'cinque', 'translation' => 'five'],
                ['word' => 'sei', 'translation' => 'six'],
            ],
            'basic phrases' => [
                ['word' => 'per favore', 'translation' => 'please'],
                ['word' => 'grazie', 'translation' => 'thank you'],
                ['word' => 'prego', 'translation' => "you're welcome"],
                ['word' => 'scusa', 'translation' => "I'm sorry"],
                ['word' => "s\u{00EC}", 'translation' => 'yes'],
                ['word' => 'no', 'translation' => 'no'],
            ],
            'family members' => [
                ['word' => 'madre', 'translation' => 'mother'],
                ['word' => 'padre', 'translation' => 'father'],
                ['word' => 'fratello', 'translation' => 'brother'],
                ['word' => 'sorella', 'translation' => 'sister'],
                ['word' => 'figlio', 'translation' => 'son'],
                ['word' => 'figlia', 'translation' => 'daughter'],
            ],
            'colors' => [
                ['word' => 'rosso', 'translation' => 'red'],
                ['word' => 'blu', 'translation' => 'blue'],
                ['word' => 'verde', 'translation' => 'green'],
                ['word' => 'giallo', 'translation' => 'yellow'],
                ['word' => 'bianco', 'translation' => 'white'],
                ['word' => 'nero', 'translation' => 'black'],
            ],
            'food basics' => [
                ['word' => 'acqua', 'translation' => 'water'],
                ['word' => 'pane', 'translation' => 'bread'],
                ['word' => 'latte', 'translation' => 'milk'],
                ['word' => "caff\u{00E8}", 'translation' => 'coffee'],
                ['word' => 'formaggio', 'translation' => 'cheese'],
                ['word' => 'pasta', 'translation' => 'pasta'],
            ],
            'the house' => [
                ['word' => 'casa', 'translation' => 'house'],
                ['word' => 'stanza', 'translation' => 'room'],
                ['word' => 'cucina', 'translation' => 'kitchen'],
                ['word' => 'bagno', 'translation' => 'bathroom'],
                ['word' => 'soggiorno', 'translation' => 'living room'],
                ['word' => 'camera da letto', 'translation' => 'bedroom'],
            ],
            'common verbs' => [
                ['word' => 'essere', 'translation' => 'to be'],
                ['word' => 'avere', 'translation' => 'to have'],
                ['word' => 'fare', 'translation' => 'to do / to make'],
                ['word' => 'andare', 'translation' => 'to go'],
                ['word' => 'venire', 'translation' => 'to come'],
                ['word' => 'volere', 'translation' => 'to want'],
            ],
        ];
    }

    private function portuguese(): array
    {
        return [
            'greetings' => [
                ['word' => "ol\u{00E1}", 'translation' => 'hello'],
                ['word' => 'adeus', 'translation' => 'goodbye'],
                ['word' => 'bom dia', 'translation' => 'good morning'],
                ['word' => 'boa tarde', 'translation' => 'good afternoon'],
                ['word' => 'boa noite', 'translation' => 'good night'],
                ['word' => "at\u{00E9} logo", 'translation' => 'see you later'],
            ],
            'introductions' => [
                ['word' => 'meu nome \u{00E9}', 'translation' => 'my name is'],
                ['word' => "como voc\u{00EA} se chama?", 'translation' => 'what is your name?'],
                ['word' => 'muito prazer', 'translation' => 'nice to meet you'],
                ['word' => 'eu sou de', 'translation' => 'I am from'],
                ['word' => "como voc\u{00EA} est\u{00E1}?", 'translation' => 'how are you?'],
                ['word' => 'eu estou bem', 'translation' => "I'm fine"],
            ],
            'numbers 1-10' => [
                ['word' => 'um', 'translation' => 'one'],
                ['word' => 'dois', 'translation' => 'two'],
                ['word' => "tr\u{00EA}s", 'translation' => 'three'],
                ['word' => 'quatro', 'translation' => 'four'],
                ['word' => 'cinco', 'translation' => 'five'],
                ['word' => 'seis', 'translation' => 'six'],
            ],
            'basic phrases' => [
                ['word' => 'por favor', 'translation' => 'please'],
                ['word' => 'obrigado', 'translation' => 'thank you'],
                ['word' => 'de nada', 'translation' => "you're welcome"],
                ['word' => 'desculpe', 'translation' => "I'm sorry"],
                ['word' => 'sim', 'translation' => 'yes'],
                ['word' => "n\u{00E3}o", 'translation' => 'no'],
            ],
            'family members' => [
                ['word' => "m\u{00E3}e", 'translation' => 'mother'],
                ['word' => 'pai', 'translation' => 'father'],
                ['word' => "irm\u{00E3}o", 'translation' => 'brother'],
                ['word' => "irm\u{00E3}", 'translation' => 'sister'],
                ['word' => 'filho', 'translation' => 'son'],
                ['word' => 'filha', 'translation' => 'daughter'],
            ],
            'colors' => [
                ['word' => 'vermelho', 'translation' => 'red'],
                ['word' => 'azul', 'translation' => 'blue'],
                ['word' => 'verde', 'translation' => 'green'],
                ['word' => 'amarelo', 'translation' => 'yellow'],
                ['word' => 'branco', 'translation' => 'white'],
                ['word' => 'preto', 'translation' => 'black'],
            ],
            'food basics' => [
                ['word' => "\u{00E1}gua", 'translation' => 'water'],
                ['word' => "p\u{00E3}o", 'translation' => 'bread'],
                ['word' => 'leite', 'translation' => 'milk'],
                ['word' => "caf\u{00E9}", 'translation' => 'coffee'],
                ['word' => 'queijo', 'translation' => 'cheese'],
                ['word' => 'carne', 'translation' => 'meat'],
            ],
            'common verbs' => [
                ['word' => 'ser', 'translation' => 'to be (permanent)'],
                ['word' => 'estar', 'translation' => 'to be (temporary)'],
                ['word' => 'ter', 'translation' => 'to have'],
                ['word' => 'fazer', 'translation' => 'to do / to make'],
                ['word' => 'ir', 'translation' => 'to go'],
                ['word' => 'querer', 'translation' => 'to want'],
            ],
        ];
    }

    private function japanese(): array
    {
        return [
            'greetings' => [
                ['word' => 'konnichiwa', 'translation' => 'hello'],
                ['word' => 'sayounara', 'translation' => 'goodbye'],
                ['word' => 'ohayou gozaimasu', 'translation' => 'good morning'],
                ['word' => 'konbanwa', 'translation' => 'good evening'],
                ['word' => 'oyasumi nasai', 'translation' => 'good night'],
                ['word' => 'mata ne', 'translation' => 'see you later'],
            ],
            'introductions' => [
                ['word' => 'watashi wa ... desu', 'translation' => 'I am ...'],
                ['word' => 'onamae wa?', 'translation' => 'what is your name?'],
                ['word' => 'hajimemashite', 'translation' => 'nice to meet you'],
                ['word' => '... kara kimashita', 'translation' => 'I came from ...'],
                ['word' => 'ogenki desu ka?', 'translation' => 'how are you?'],
                ['word' => 'genki desu', 'translation' => "I'm fine"],
            ],
            'numbers 1-10' => [
                ['word' => 'ichi', 'translation' => 'one'],
                ['word' => 'ni', 'translation' => 'two'],
                ['word' => 'san', 'translation' => 'three'],
                ['word' => 'shi / yon', 'translation' => 'four'],
                ['word' => 'go', 'translation' => 'five'],
                ['word' => 'roku', 'translation' => 'six'],
            ],
            'basic phrases' => [
                ['word' => 'onegaishimasu', 'translation' => 'please'],
                ['word' => 'arigatou gozaimasu', 'translation' => 'thank you'],
                ['word' => 'dou itashimashite', 'translation' => "you're welcome"],
                ['word' => 'sumimasen', 'translation' => 'excuse me / sorry'],
                ['word' => 'hai', 'translation' => 'yes'],
                ['word' => 'iie', 'translation' => 'no'],
            ],
            'family members' => [
                ['word' => 'okaasan', 'translation' => 'mother'],
                ['word' => 'otousan', 'translation' => 'father'],
                ['word' => 'oniisan', 'translation' => 'older brother'],
                ['word' => 'oneesan', 'translation' => 'older sister'],
                ['word' => 'musuko', 'translation' => 'son'],
                ['word' => 'musume', 'translation' => 'daughter'],
            ],
            'food basics' => [
                ['word' => 'mizu', 'translation' => 'water'],
                ['word' => 'gohan', 'translation' => 'rice / meal'],
                ['word' => 'niku', 'translation' => 'meat'],
                ['word' => 'sakana', 'translation' => 'fish'],
                ['word' => 'yasai', 'translation' => 'vegetables'],
                ['word' => 'ocha', 'translation' => 'tea'],
            ],
            'common verbs' => [
                ['word' => 'taberu', 'translation' => 'to eat'],
                ['word' => 'nomu', 'translation' => 'to drink'],
                ['word' => 'iku', 'translation' => 'to go'],
                ['word' => 'kuru', 'translation' => 'to come'],
                ['word' => 'miru', 'translation' => 'to see'],
                ['word' => 'hanasu', 'translation' => 'to speak'],
            ],
        ];
    }

    private function dutch(): array
    {
        return [
            'greetings' => [
                ['word' => 'hallo', 'translation' => 'hello'],
                ['word' => 'dag', 'translation' => 'goodbye'],
                ['word' => 'goedemorgen', 'translation' => 'good morning'],
                ['word' => 'goedemiddag', 'translation' => 'good afternoon'],
                ['word' => 'goedenavond', 'translation' => 'good evening'],
                ['word' => 'tot ziens', 'translation' => 'see you later'],
            ],
            'introductions' => [
                ['word' => 'ik heet', 'translation' => 'my name is'],
                ['word' => 'hoe heet je?', 'translation' => 'what is your name?'],
                ['word' => 'aangenaam', 'translation' => 'nice to meet you'],
                ['word' => 'ik kom uit', 'translation' => 'I come from'],
                ['word' => 'hoe gaat het?', 'translation' => 'how are you?'],
                ['word' => 'goed, dank je', 'translation' => "fine, thank you"],
            ],
            'numbers 1-10' => [
                ['word' => "e\u{00E9}n", 'translation' => 'one'],
                ['word' => 'twee', 'translation' => 'two'],
                ['word' => 'drie', 'translation' => 'three'],
                ['word' => 'vier', 'translation' => 'four'],
                ['word' => 'vijf', 'translation' => 'five'],
                ['word' => 'zes', 'translation' => 'six'],
            ],
            'basic phrases' => [
                ['word' => 'alstublieft', 'translation' => 'please'],
                ['word' => 'dank u wel', 'translation' => 'thank you'],
                ['word' => 'graag gedaan', 'translation' => "you're welcome"],
                ['word' => 'sorry', 'translation' => "I'm sorry"],
                ['word' => 'ja', 'translation' => 'yes'],
                ['word' => 'nee', 'translation' => 'no'],
            ],
            'family members' => [
                ['word' => 'moeder', 'translation' => 'mother'],
                ['word' => 'vader', 'translation' => 'father'],
                ['word' => 'broer', 'translation' => 'brother'],
                ['word' => 'zus', 'translation' => 'sister'],
                ['word' => 'zoon', 'translation' => 'son'],
                ['word' => 'dochter', 'translation' => 'daughter'],
            ],
            'colors' => [
                ['word' => 'rood', 'translation' => 'red'],
                ['word' => 'blauw', 'translation' => 'blue'],
                ['word' => 'groen', 'translation' => 'green'],
                ['word' => 'geel', 'translation' => 'yellow'],
                ['word' => 'wit', 'translation' => 'white'],
                ['word' => 'zwart', 'translation' => 'black'],
            ],
            'food basics' => [
                ['word' => 'water', 'translation' => 'water'],
                ['word' => 'brood', 'translation' => 'bread'],
                ['word' => 'melk', 'translation' => 'milk'],
                ['word' => 'koffie', 'translation' => 'coffee'],
                ['word' => 'kaas', 'translation' => 'cheese'],
                ['word' => 'vlees', 'translation' => 'meat'],
            ],
            'the house' => [
                ['word' => 'huis', 'translation' => 'house'],
                ['word' => 'kamer', 'translation' => 'room'],
                ['word' => 'keuken', 'translation' => 'kitchen'],
                ['word' => 'badkamer', 'translation' => 'bathroom'],
                ['word' => 'woonkamer', 'translation' => 'living room'],
                ['word' => 'slaapkamer', 'translation' => 'bedroom'],
            ],
            'days of the week' => [
                ['word' => 'maandag', 'translation' => 'Monday'],
                ['word' => 'dinsdag', 'translation' => 'Tuesday'],
                ['word' => 'woensdag', 'translation' => 'Wednesday'],
                ['word' => 'donderdag', 'translation' => 'Thursday'],
                ['word' => 'vrijdag', 'translation' => 'Friday'],
                ['word' => 'zaterdag', 'translation' => 'Saturday'],
            ],
            'common verbs' => [
                ['word' => 'zijn', 'translation' => 'to be'],
                ['word' => 'hebben', 'translation' => 'to have'],
                ['word' => 'doen', 'translation' => 'to do'],
                ['word' => 'gaan', 'translation' => 'to go'],
                ['word' => 'komen', 'translation' => 'to come'],
                ['word' => 'willen', 'translation' => 'to want'],
            ],
            'animals' => [
                ['word' => 'hond', 'translation' => 'dog'],
                ['word' => 'kat', 'translation' => 'cat'],
                ['word' => 'vogel', 'translation' => 'bird'],
                ['word' => 'paard', 'translation' => 'horse'],
                ['word' => 'vis', 'translation' => 'fish'],
                ['word' => 'vlinder', 'translation' => 'butterfly'],
            ],
            'weather' => [
                ['word' => 'zon', 'translation' => 'sun'],
                ['word' => 'regen', 'translation' => 'rain'],
                ['word' => 'sneeuw', 'translation' => 'snow'],
                ['word' => 'wind', 'translation' => 'wind'],
                ['word' => 'bewolkt', 'translation' => 'cloudy'],
                ['word' => 'het is warm', 'translation' => "it's warm"],
            ],
            'transport' => [
                ['word' => 'auto', 'translation' => 'car'],
                ['word' => 'bus', 'translation' => 'bus'],
                ['word' => 'trein', 'translation' => 'train'],
                ['word' => 'vliegtuig', 'translation' => 'airplane'],
                ['word' => 'fiets', 'translation' => 'bicycle'],
                ['word' => 'metro', 'translation' => 'metro'],
            ],
            'body parts' => [
                ['word' => 'hoofd', 'translation' => 'head'],
                ['word' => 'hand', 'translation' => 'hand'],
                ['word' => 'voet', 'translation' => 'foot'],
                ['word' => 'oog', 'translation' => 'eye'],
                ['word' => 'mond', 'translation' => 'mouth'],
                ['word' => 'hart', 'translation' => 'heart'],
            ],
            'feelings' => [
                ['word' => 'blij', 'translation' => 'happy'],
                ['word' => 'verdrietig', 'translation' => 'sad'],
                ['word' => 'moe', 'translation' => 'tired'],
                ['word' => 'boos', 'translation' => 'angry'],
                ['word' => 'zenuwachtig', 'translation' => 'nervous'],
                ['word' => 'rustig', 'translation' => 'calm'],
            ],
            'hobbies' => [
                ['word' => 'lezen', 'translation' => 'to read'],
                ['word' => 'schrijven', 'translation' => 'to write'],
                ['word' => 'koken', 'translation' => 'to cook'],
                ['word' => 'dansen', 'translation' => 'to dance'],
                ['word' => 'zingen', 'translation' => 'to sing'],
                ['word' => 'zwemmen', 'translation' => 'to swim'],
            ],
            'professions' => [
                ['word' => 'dokter', 'translation' => 'doctor'],
                ['word' => 'advocaat', 'translation' => 'lawyer'],
                ['word' => 'ingenieur', 'translation' => 'engineer'],
                ['word' => 'verpleegkundige', 'translation' => 'nurse'],
                ['word' => 'kok', 'translation' => 'cook'],
                ['word' => 'leraar', 'translation' => 'teacher'],
            ],
            'daily routine' => [
                ['word' => 'wakker worden', 'translation' => 'to wake up'],
                ['word' => 'douchen', 'translation' => 'to shower'],
                ['word' => 'aankleden', 'translation' => 'to get dressed'],
                ['word' => 'werken', 'translation' => 'to work'],
                ['word' => 'eten', 'translation' => 'to eat'],
                ['word' => 'slapen', 'translation' => 'to sleep'],
            ],
        ];
    }

    private function turkish(): array
    {
        return [
            'greetings' => [
                ['word' => 'merhaba', 'translation' => 'hello'],
                ['word' => "ho\u{015F}\u{00E7}a kal", 'translation' => 'goodbye'],
                ['word' => "g\u{00FC}nayd\u{0131}n", 'translation' => 'good morning'],
                ['word' => 'iyi aksamlar', 'translation' => 'good evening'],
                ['word' => 'iyi geceler', 'translation' => 'good night'],
                ['word' => "g\u{00F6}r\u{00FC}\u{015F}\u{00FC}r\u{00FC}z", 'translation' => 'see you later'],
            ],
            'introductions' => [
                ['word' => "benim ad\u{0131}m", 'translation' => 'my name is'],
                ['word' => "ad\u{0131}n\u{0131}z ne?", 'translation' => 'what is your name?'],
                ['word' => "memnun oldum", 'translation' => 'nice to meet you'],
                ['word' => "nas\u{0131}ls\u{0131}n\u{0131}z?", 'translation' => 'how are you?'],
                ['word' => "iyiyim", 'translation' => "I'm fine"],
                ['word' => "te\u{015F}ekk\u{00FC}r ederim", 'translation' => 'thank you'],
            ],
            'numbers 1-10' => [
                ['word' => 'bir', 'translation' => 'one'],
                ['word' => 'iki', 'translation' => 'two'],
                ['word' => "\u{00FC}\u{00E7}", 'translation' => 'three'],
                ['word' => "d\u{00F6}rt", 'translation' => 'four'],
                ['word' => "be\u{015F}", 'translation' => 'five'],
                ['word' => "alt\u{0131}", 'translation' => 'six'],
            ],
            'basic phrases' => [
                ['word' => "l\u{00FC}tfen", 'translation' => 'please'],
                ['word' => 'evet', 'translation' => 'yes'],
                ['word' => "hay\u{0131}r", 'translation' => 'no'],
                ['word' => "affedersiniz", 'translation' => 'excuse me'],
                ['word' => "anlamad\u{0131}m", 'translation' => "I don't understand"],
                ['word' => "ne kadar?", 'translation' => 'how much?'],
            ],
            'food basics' => [
                ['word' => 'su', 'translation' => 'water'],
                ['word' => 'ekmek', 'translation' => 'bread'],
                ['word' => "s\u{00FC}t", 'translation' => 'milk'],
                ['word' => 'kahve', 'translation' => 'coffee'],
                ['word' => 'peynir', 'translation' => 'cheese'],
                ['word' => "\u{00E7}ay", 'translation' => 'tea'],
            ],
            'family members' => [
                ['word' => 'anne', 'translation' => 'mother'],
                ['word' => 'baba', 'translation' => 'father'],
                ['word' => 'erkek karde\u{015F}', 'translation' => 'brother'],
                ['word' => "k\u{0131}z karde\u{015F}", 'translation' => 'sister'],
                ['word' => "o\u{011F}ul", 'translation' => 'son'],
                ['word' => "k\u{0131}z", 'translation' => 'daughter'],
            ],
            'common verbs' => [
                ['word' => 'olmak', 'translation' => 'to be'],
                ['word' => 'yapmak', 'translation' => 'to do / to make'],
                ['word' => 'gitmek', 'translation' => 'to go'],
                ['word' => 'gelmek', 'translation' => 'to come'],
                ['word' => 'istemek', 'translation' => 'to want'],
                ['word' => 'bilmek', 'translation' => 'to know'],
            ],
        ];
    }

    private function russian(): array
    {
        return [
            'greetings' => [
                ['word' => 'privet', 'translation' => 'hello (informal)'],
                ['word' => 'zdravstvuyte', 'translation' => 'hello (formal)'],
                ['word' => 'do svidaniya', 'translation' => 'goodbye'],
                ['word' => 'dobroye utro', 'translation' => 'good morning'],
                ['word' => 'dobryy vecher', 'translation' => 'good evening'],
                ['word' => 'spokoynoy nochi', 'translation' => 'good night'],
            ],
            'introductions' => [
                ['word' => 'menya zovut', 'translation' => 'my name is'],
                ['word' => 'kak vas zovut?', 'translation' => 'what is your name?'],
                ['word' => 'ochen priyatno', 'translation' => 'nice to meet you'],
                ['word' => 'ya iz', 'translation' => 'I am from'],
                ['word' => 'kak dela?', 'translation' => 'how are you?'],
                ['word' => 'khorosho', 'translation' => 'good / fine'],
            ],
            'numbers 1-10' => [
                ['word' => 'odin', 'translation' => 'one'],
                ['word' => 'dva', 'translation' => 'two'],
                ['word' => 'tri', 'translation' => 'three'],
                ['word' => 'chetyre', 'translation' => 'four'],
                ['word' => 'pyat', 'translation' => 'five'],
                ['word' => 'shest', 'translation' => 'six'],
            ],
            'basic phrases' => [
                ['word' => 'pozhaluysta', 'translation' => 'please'],
                ['word' => 'spasibo', 'translation' => 'thank you'],
                ['word' => 'da', 'translation' => 'yes'],
                ['word' => 'nyet', 'translation' => 'no'],
                ['word' => 'izvinite', 'translation' => 'excuse me'],
                ['word' => 'ya ne ponimayu', 'translation' => "I don't understand"],
            ],
            'food basics' => [
                ['word' => 'voda', 'translation' => 'water'],
                ['word' => 'khleb', 'translation' => 'bread'],
                ['word' => 'moloko', 'translation' => 'milk'],
                ['word' => 'kofe', 'translation' => 'coffee'],
                ['word' => 'syr', 'translation' => 'cheese'],
                ['word' => 'chay', 'translation' => 'tea'],
            ],
            'family members' => [
                ['word' => 'mama', 'translation' => 'mother'],
                ['word' => 'papa', 'translation' => 'father'],
                ['word' => 'brat', 'translation' => 'brother'],
                ['word' => 'sestra', 'translation' => 'sister'],
                ['word' => 'syn', 'translation' => 'son'],
                ['word' => 'doch', 'translation' => 'daughter'],
            ],
            'common verbs' => [
                ['word' => 'byt', 'translation' => 'to be'],
                ['word' => 'imet', 'translation' => 'to have'],
                ['word' => 'delat', 'translation' => 'to do'],
                ['word' => 'idti', 'translation' => 'to go'],
                ['word' => 'khotet', 'translation' => 'to want'],
                ['word' => 'znat', 'translation' => 'to know'],
            ],
        ];
    }

    private function arabic(): array
    {
        return [
            'greetings' => [
                ['word' => 'marhaba', 'translation' => 'hello'],
                ['word' => 'ma\'a salama', 'translation' => 'goodbye'],
                ['word' => 'sabah al-khayr', 'translation' => 'good morning'],
                ['word' => 'masa al-khayr', 'translation' => 'good evening'],
                ['word' => 'tisbah ala khayr', 'translation' => 'good night'],
                ['word' => 'ila al-liqa', 'translation' => 'see you later'],
            ],
            'introductions' => [
                ['word' => 'ismi', 'translation' => 'my name is'],
                ['word' => 'ma ismak?', 'translation' => 'what is your name?'],
                ['word' => 'tasharrafna', 'translation' => 'nice to meet you'],
                ['word' => 'ana min', 'translation' => 'I am from'],
                ['word' => 'kayf halak?', 'translation' => 'how are you?'],
                ['word' => 'ana bi-khayr', 'translation' => "I'm fine"],
            ],
            'numbers 1-10' => [
                ['word' => 'wahid', 'translation' => 'one'],
                ['word' => 'ithnan', 'translation' => 'two'],
                ['word' => 'thalatha', 'translation' => 'three'],
                ['word' => 'arba\'a', 'translation' => 'four'],
                ['word' => 'khamsa', 'translation' => 'five'],
                ['word' => 'sitta', 'translation' => 'six'],
            ],
            'basic phrases' => [
                ['word' => 'min fadlak', 'translation' => 'please'],
                ['word' => 'shukran', 'translation' => 'thank you'],
                ['word' => 'afwan', 'translation' => "you're welcome"],
                ['word' => 'na\'am', 'translation' => 'yes'],
                ['word' => 'la', 'translation' => 'no'],
                ['word' => 'la afham', 'translation' => "I don't understand"],
            ],
            'food basics' => [
                ['word' => 'ma\'', 'translation' => 'water'],
                ['word' => 'khubz', 'translation' => 'bread'],
                ['word' => 'halib', 'translation' => 'milk'],
                ['word' => 'qahwa', 'translation' => 'coffee'],
                ['word' => 'shay', 'translation' => 'tea'],
                ['word' => 'lahem', 'translation' => 'meat'],
            ],
            'family members' => [
                ['word' => 'umm', 'translation' => 'mother'],
                ['word' => 'ab', 'translation' => 'father'],
                ['word' => 'akh', 'translation' => 'brother'],
                ['word' => 'ukht', 'translation' => 'sister'],
                ['word' => 'ibn', 'translation' => 'son'],
                ['word' => 'bint', 'translation' => 'daughter'],
            ],
            'common verbs' => [
                ['word' => 'yakun', 'translation' => 'to be'],
                ['word' => 'ya\'mal', 'translation' => 'to do'],
                ['word' => 'yadhhab', 'translation' => 'to go'],
                ['word' => 'ya\'ti', 'translation' => 'to come'],
                ['word' => 'yurid', 'translation' => 'to want'],
                ['word' => 'ya\'rif', 'translation' => 'to know'],
            ],
        ];
    }

    private function chinese(): array
    {
        return [
            'greetings' => [
                ['word' => "n\u{01D0} h\u{01CE}o", 'translation' => 'hello'],
                ['word' => "z\u{00E0}i ji\u{00E0}n", 'translation' => 'goodbye'],
                ['word' => "z\u{01CE}o sh\u{00E0}ng h\u{01CE}o", 'translation' => 'good morning'],
                ['word' => "w\u{01CE}n sh\u{00E0}ng h\u{01CE}o", 'translation' => 'good evening'],
                ['word' => "w\u{01CE}n \u{0101}n", 'translation' => 'good night'],
                ['word' => "hu\u{00ED} t\u{00F3}u ji\u{00E0}n", 'translation' => 'see you later'],
            ],
            'introductions' => [
                ['word' => "w\u{01D2} ji\u{00E0}o", 'translation' => 'my name is'],
                ['word' => "n\u{01D0} ji\u{00E0}o sh\u{00E9}nme?", 'translation' => 'what is your name?'],
                ['word' => "h\u{011B}n g\u{0101}ox\u{00EC}ng", 'translation' => 'nice to meet you'],
                ['word' => "w\u{01D2} l\u{00E1}i z\u{00EC}", 'translation' => 'I come from'],
                ['word' => "n\u{01D0} h\u{01CE}o ma?", 'translation' => 'how are you?'],
                ['word' => "w\u{01D2} h\u{011B}n h\u{01CE}o", 'translation' => "I'm fine"],
            ],
            'numbers 1-10' => [
                ['word' => "y\u{012B}", 'translation' => 'one'],
                ['word' => "\u{00E8}r", 'translation' => 'two'],
                ['word' => "s\u{0101}n", 'translation' => 'three'],
                ['word' => "s\u{00EC}", 'translation' => 'four'],
                ['word' => "w\u{01D4}", 'translation' => 'five'],
                ['word' => "li\u{00F9}", 'translation' => 'six'],
            ],
            'basic phrases' => [
                ['word' => "q\u{01D0}ng", 'translation' => 'please'],
                ['word' => "xi\u{00E8}xie", 'translation' => 'thank you'],
                ['word' => "b\u{00FA} k\u{00E8}qi", 'translation' => "you're welcome"],
                ['word' => "du\u{00EC} b\u{00F9} q\u{01D0}", 'translation' => "I'm sorry"],
                ['word' => "sh\u{00EC}", 'translation' => 'yes'],
                ['word' => "b\u{00FA} sh\u{00EC}", 'translation' => 'no'],
            ],
            'food basics' => [
                ['word' => "shu\u{01D0}", 'translation' => 'water'],
                ['word' => "mi\u{00E0}n b\u{0101}o", 'translation' => 'bread'],
                ['word' => "ni\u{00FA} n\u{01CE}i", 'translation' => 'milk'],
                ['word' => "k\u{0101}f\u{0113}i", 'translation' => 'coffee'],
                ['word' => "ch\u{00E1}", 'translation' => 'tea'],
                ['word' => "m\u{01D0} f\u{00E0}n", 'translation' => 'rice'],
            ],
            'family members' => [
                ['word' => "m\u{0101}ma", 'translation' => 'mother'],
                ['word' => "b\u{00E0}ba", 'translation' => 'father'],
                ['word' => "g\u{0113}ge", 'translation' => 'older brother'],
                ['word' => "ji\u{011B}jie", 'translation' => 'older sister'],
                ['word' => "\u{00E9}rzi", 'translation' => 'son'],
                ['word' => "n\u{01DA}\u{00E9}r", 'translation' => 'daughter'],
            ],
            'common verbs' => [
                ['word' => "sh\u{00EC}", 'translation' => 'to be'],
                ['word' => "y\u{01D2}u", 'translation' => 'to have'],
                ['word' => "zu\u{00F2}", 'translation' => 'to do'],
                ['word' => "q\u{00F9}", 'translation' => 'to go'],
                ['word' => "l\u{00E1}i", 'translation' => 'to come'],
                ['word' => "xi\u{01CE}ng", 'translation' => 'to want'],
            ],
        ];
    }
}
