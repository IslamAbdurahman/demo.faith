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

    'accepted' => 'The :attribute должен быть принят.',
    'accepted_if' => 'The :attribute должно быть принято, когда :other is :value.',
    'active_url' => 'The :attribute не является действительным URL.',
    'after' => 'The :attribute должна быть дата после :date.',
    'after_or_equal' => 'The :attribute должна быть датой после или равной :date.',
    'alpha' => 'The :attribute должен содержать только буквы.',
    'alpha_dash' => 'The :attribute должен содержать только буквы, цифры, дефисы и символы подчеркивания.',
    'alpha_num' => 'The :attribute должен содержать только буквы и цифры.',
    'array' => 'The :attribute должен быть массив.',
    'before' => 'The :attribute должна быть дата до :date.',
    'before_or_equal' => 'The :attribute должна быть датой до или равной :date.',
    'between' => [
        'array' => 'The :attribute должно быть между :min and :max items.',
        'file' => 'The :attribute должно быть между :min and :max kilobytes.',
        'numeric' => 'The :attribute должно быть между :min and :max.',
        'string' => 'The :attribute должно быть между :min and :max characters.',
    ],
    'boolean' => 'The :attribute поле должно быть истинным или ложным.',
    'confirmed' => 'The :attribute подтверждение не совпадает.',
    'current_password' => 'Неправильный пароль.',
    'date' => 'The :attribute недопустимая дата.',
    'date_equals' => 'The :attribute должна быть дата, равная:date.',
    'date_format' => 'The :attribute не соответствует формату :format.',
    'declined' => 'The :attribute должен быть отклонен.',
    'declined_if' => 'The :attribute должен быть отклонен, когда :other is :value.',
    'different' => 'The :attribute и :other должен быть другим.',
    'digits' => 'The :attribute должно быть :цифры цифры.',
    'digits_between' => 'The :attribute должно быть между цифрами :min и :max.',
    'dimensions' => 'The :attribute имеет недопустимые размеры изображения.',
    'distinct' => 'The :attribute поле имеет повторяющееся значение.',
    'email' => 'The :attribute Адрес эл. почты должен быть действительным.',
    'ends_with' => 'The :attribute должен заканчиваться одним из следующих символов: :values.',
    'enum' => 'The selected :атрибут недействителен.',
    'exists' => 'The selected :атрибут недействителен.',
    'file' => 'The :attribute должен быть файл.',
    'filled' => 'The :attribute поле должно иметь значение.',
    'gt' => [
        'array' => 'The :attribute должно быть больше, чем :value items.',
        'file' => 'The :attribute должно быть больше, чем :value kilobytes.',
        'numeric' => 'The :attribute должно быть больше, чем :value.',
        'string' => 'The :attribute должно быть больше, чем :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute должны иметь элементы :value или более.',
        'file' => 'The :attribute должно быть больше или равно :value килобайт.',
        'numeric' => 'The :attribute должно быть больше или равно :value.',
        'string' => 'The :attribute должно быть больше или равно :value символов.',
    ],
    'image' => 'The :attribute должно быть изображение.',
    'in' => 'The selected :attribute является недействительным.',
    'in_array' => 'The :attribute поле не существует в :other.',
    'integer' => 'The :attribute должно быть целым числом.',
    'ip' => 'The :attribute должен быть действительным IP-адресом.',
    'ipv4' => 'The :attribute должен быть действительным адресом IPv4.',
    'ipv6' => 'The :attribute должен быть действительным адресом IPv6.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'array' => 'The :attribute должно быть меньше, чем :value items.',
        'file' => 'The :attribute должно быть меньше, чем :value kilobytes.',
        'numeric' => 'The :attribute должно быть меньше, чем :value.',
        'string' => 'The :attribute должно быть меньше, чем:value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute не должен иметь более :value items.',
        'file' => 'The :attribute должно быть меньше или равно :value kilobytes.',
        'numeric' => 'The :attribute должно быть меньше или равно :value.',
        'string' => 'The :attribute должно быть меньше или равно :value characters.',
    ],
    'mac_address' => 'The :attribute должен быть действительным MAC-адресом.',
    'max' => [
        'array' => 'The :attribute не должен иметь более :max items.',
        'file' => 'The :attribute не должен иметь более.',
        'numeric' => 'The :attribute не должно быть больше, чем : max.',
        'string' => 'The :attribute не должно быть больше, чем :max characters.',
    ],
    'mimes' => 'The :attribute должен быть файл типа: :values.',
    'mimetypes' => 'The :attribute должен быть файл типа: :values.',
    'min' => [
        'array' => 'The :attribute должен иметь по крайней мере :min items.',
        'file' => 'The :attribute должен быть не менее :min kilobytes.',
        'numeric' => 'The :attribute должен быть не менее :min.',
        'string' => 'The :attribute должен быть не менее :min characters.',
    ],
    'multiple_of' => 'The :attribute должно быть кратно :value.',
    'not_in' => 'The selected :атрибут недействителен.',
    'not_regex' => 'The :attribute формат недействителен.',
    'numeric' => 'The :attribute должен быть числом.',
    'password' => [
        'mixed' => 'The :attribute должен содержать хотя бы одну заглавную и одну строчную букву.',
        'letters' => 'The :attribute должен содержать хотя бы одну букву.',
        'symbols' => 'The :attribute должен содержать хотя бы одну букву.',
        'numbers' => 'The :attribute должен содержать хотя бы одну букву.',
        'uncompromised' => 'The given :attribute оказалось в утечке данных. Пожалуйста, выберите другой :attribute.',
    ],
    'present' => 'The :attribute поле должно присутствовать.',
    'prohibited' => 'The :attribute поле запрещено.',
    'prohibited_if' => 'The :attribute поле запрещено, когда:other is :value.',
    'prohibited_unless' => 'The :attribute поле запрещено, если :other is in :values.',
    'prohibits' => 'The :attribute поле запрещает :other from being present.',
    'regex' => 'The :attribute поле запрещает.',
    'required' => 'The :attribute field is required.',
    'required_array_keys' => 'The :attribute поле должно содержать записи для: :values.',
    'required_if' => 'The :attribute поле обязательно, когда :other is :value.',
    'required_unless' => 'The :attribute поле обязательно, если только :other is in :values.',
    'required_with' => 'The :attribute поле обязательно, когда :values is present.',
    'required_with_all' => 'The :attribute поле обязательно, когда :values are present.',
    'required_without' => 'The :attribute поле обязательно, когда :values is not present.',
    'required_without_all' => 'The :attribute поле является обязательным, если ни одно из:values are present.',
    'same' => 'The :attribute and :другое должно соответствовать.',
    'size' => [
        'array' => 'The :attribute must contain :size items.',
        'file' => 'The :attribute must be :size kilobytes.',
        'numeric' => 'The :attribute must be :size.',
        'string' => 'The :attribute must be :size characters.',
    ],
        'starts_with' => 'The :attribute должен начинаться с одного из следующих: :values.',
    'string' => 'The :attribute должна быть строка.',
    'timezone' => 'The :attribute должен быть допустимым часовым поясом.',
    'unique' => 'The :attribute уже принято.',
    'uploaded' => 'The :attribute не удалось загрузить.',
    'url' => 'The :attribute должен быть действительным URL.',
    'uuid' => 'The :attribute должен быть допустимым UUID.',

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
