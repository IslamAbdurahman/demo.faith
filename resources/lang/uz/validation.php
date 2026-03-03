<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The:attribute qabul qilinishi kerak.',
    'accepted_if' => 'The :attribute qachon qabul qilinishi kerak :other is :value.',
    'active_url' => 'The :attribute haqiqiy URL emas.',
    'after' => 'The :attribute keyin sana bo`lishi kerak :date.',
    'after_or_equal' => 'The :attribute sanadan keyin yoki unga teng bo`lishi kerak :date.',
    'alpha' => 'The :attribute faqat harflardan iborat bo`lishi kerak.',
    'alpha_dash' => 'The :attribute faqat harflar, raqamlar, tire va pastki chiziqdan iborat bo`lishi kerak.',
    'alpha_num' => 'The :attribute faqat harflar va raqamlardan iborat bo`lishi kerak.',
    'array' => 'The :attribute massiv bo`lishi kerak.',
    'before' => 'The :attribute oldin sana bo`lishi kerak :date.',
    'before_or_equal' => 'The :attribute sanadan oldin yoki unga teng bo`lishi kerak :date.',
    'between' => [
        'array' => 'The :attribute orasida bo`lishi kerak:min and :max items.',
        'file' => 'The :attribute orasida bo`lishi kerak :min and :max kilobytes.',
        'numeric' => 'The :attribute orasida bo`lishi kerak :min and :max.',
        'string' => 'The :attribute orasida bo`lishi kerak:min and :max characters.',
    ],
    'boolean' => 'The :attribute maydon rost yoki noto`g`ri bo`ishi kerak.',
    'confirmed' => 'The :attribute tasdiqlash mos kelmaydi.',
    'current_password' => 'The parol noto`g`ri.',
    'date' => 'The :attribute haqiqiy sana emas.',
    'date_equals' => 'The :attribute shu vaqtga teng bo`lishi kerak :date.',
    'date_format' => 'The :attribute formati mos kelmadi :format.',
    'declined' => 'The :attribute rad etilishi kerak.',
    'declined_if' => 'The :attribute qachon rad etilishi kerak :other is :value.',
    'different' => 'The :attribute va :other must be different.',
    'digits' => 'The :attribute bo`lishi kerak :digits digits.',
    'digits_between' => 'The :attribute orasida bo`lishi kerak :min and :max digits.',
    'dimensions' => 'The :attribute rasm oʻlchamlari yaroqsiz.',
    'distinct' => 'The :attribute maydon dublikat qiymatiga ega.',
    'email' => 'The :attribute haqiqiy elektron pochta manzili bo`lishi kerak.',
    'ends_with' => 'The :attribute quyidagilardan biri bilan yakunlanishi kerak: :values.',
    'enum' => 'The tanlangan :attribute is invalid.',
    'exists' => 'The tanlangan :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute maydon qiymatga ega bo`lishi kerak.',
    'gt' => [
        'array' => 'The :attribute dan ortiq bo`lishi kerak :value belgilar.',
        'file' => 'The :attribute dan katta bo`lishi kerak :value kilobytes.',
        'numeric' => 'The :attribute dan katta bo`lishi kerak :value.',
        'string' => 'The :attribute :value dan katta bo`lishi kerak.',
    ],
    'gte' => [
        'array' => 'The :attribute :value bo`lishi kerak  items or more.',
        'file' => 'The :attribute :value dan katta yoki teng bo`lishi kerak  kilobytes.',
        'numeric' => 'The :attribute value dan katta yoki teng bo`lishi kerak :.',
        'string' => 'The :attribute dan katta yoki teng bo`lishi kerak :value characters.',
    ],
    'image' => 'The :attribute rasm bo`lishi kerak.',
    'in' => 'The tanlangan :attribute yaroqsiz.',
    'in_array' => 'The :attribute maydoni :other da mavjud emas.',
    'integer' => 'The :attribute raqam bo`lishi kerak.',
    'ip' => 'The :attribute IP address mavjud emas.',
    'ipv4' => 'The :attribute IPv4 address mavjud emas.',
    'ipv6' => 'The :attribute IPv6 address mavjud emas.',
    'json' => 'The :attribute JSON string mavjud emas.',
    'lt' => [
        'array' => 'The :attribute :value elemertlaridan kam bo`lishi kerak.',
        'file' => 'The :attribute :value kilobytes dan kam bo`lishi kerak. ',
        'numeric' => 'The :attribute :value dan kam bo`lishi kerak .',
        'string' => 'The :attribute :value elementlardan kam bo`lishi kerak.',
    ],
    'lte' => [
        'array' => 'The :attribute :value elentlaridan dan ortiq bo`lmasligi kerak .',
        'file' => 'The :attribute  :value kilobytes dan kichik yoki teng bo`lishi kerak.',
        'numeric' => 'The :attribute :value dan kichik yoki teng bo`lishi kerak.',
        'string' => 'The :attribute  :value characters dan kichik yoki teng bo`lishi kerak.',
    ],
    'mac_address' => 'The :attribute haqiqiy MAC manzili bo`lishi kerak.',
    'max' => [
        'array' => 'The :attribute:max elementdan dan ortiq bo`lmasligi kerak.',
        'file' => 'The :attribute dan katta bo`lmasligi kerak :max kilobytes.',
        'numeric' => 'The :attribute  :max dan katta bo`lmasligi kerak .',
        'string' => 'The :attribute :max elementdan katta bo`lmasligi kerak.',
    ],
    'mimes' => 'The :attribute: values turdagi fayl bo`lishi kerak.',
    'mimetypes' => 'The :attribute  :values quyidagi turdagi fayl bo`lishi kerak:',
    'min' => [
        'array' => 'The :attribute  :min items.',
        'file' => 'The :attribute must be at least :min hech bo`lmaganda bo`lishi kerak kilobytes.',
        'numeric' => 'The :attribute:min kamida bo`lishi kerak.',
        'string' => 'The :attribute :min characters kamida bo`lishi kerak.',
    ],
    'multiple_of' => 'The :attribute :value ning koʻpaytmasi boʻlishi kerak.',
    'not_in' => 'The selected :attribute yaroqsiz.',
    'not_regex' => 'The :attribute format yaroqsiz.',
    'numeric' => 'The :attribute raqam bo`lishi kerak.',
    'password' => [
        'mixed' => 'The :attribute kamida bitta katta va bitta kichik harfdan iborat bo`lishi kerak.',
        'letters' => 'The :attribute kamida bitta harf bo`lishi kerak.',
        'symbols' => 'The :attribute kamida bitta belgini o`z ichiga olishi kerak.',
        'numbers' => 'The :attribute kamida bitta raqamni o`z ichiga olishi kerak.',
        'uncompromised' => 'The given :attribute  ma`lumotlar sizib chiqishida paydo bo`ldi. Boshqasini tanlang.',
    ],
    'present' => 'The :attribute maydon mavjud bo`lishi kerak.',
    'prohibited' => 'The :attribute maydon taqiqlanadi.',
    'prohibited_if' => 'The :attribute qachon maydon taqiqlanadi :other is :value.',
    'prohibited_unless' => 'The :attribute bundan mustasno, maydon taqiqlanadi :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute format yaroqsiz.',
    'required' => 'Bu :attribute maydoni to`ldirilishi kerak. ',
    'required_array_keys' => 'The :attribute maydon uchun yozuvlar bo`lishi kerak: :values.',
    'required_if' => 'The :attribute  :other is :value. maydoni qachon talab qilinadi ',
    'required_unless' => 'The :attribute  :other is in maydon talab qilinmasa :values.',
    'required_with' => 'The :attribute maydoni qachon talab qilinadi :values is present.',
    'required_with_all' => 'The :attribute  :values are maydoni qachon talab qilinadi.',
    'required_without' => 'The :attribute maydoni qachon talab qilinadi :values is not present.',
    'required_without_all' => 'The :attribute hech biri bo`lmaganda maydon talab qilinadi :values are present.',
    'same' => 'The :attribute va :other mos kelish kerak.',
    'size' => [
        'array' => 'The :attribute o`z ichiga olishi kerak :size items.',
        'file' => 'The :attribute must be :size kilobytes.',
        'numeric' => 'The :attribute must be :size.',
        'string' => 'The :attribute must be :size characters.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
