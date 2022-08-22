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

    'accepted' => ':attribute يجب قبول',
    'active_url' => ' غير متاح :attribute رابط',
    'after' => 'ال :attribute يجب ان يكون بعد  :date.',
    'after_or_equal' => ' :date. يجب ان يكون بعد او في :attribute ',
    'alpha' => 'يمكن ان يحتوي علي حروف فقط :attribute',
    'alpha_dash' => 'ممكن ان يحتوي علي حروف, أرقام, ورموز  :attribute.',
    'alpha_num' => 'يمكن ان يحتوي علي حروف و أرقام فقط :attribute',
    'array' => ' :attribute must be an array.',
    'before' => ':date يجب ان يكون قبل :attribute ',
    'before_or_equal' => ':date. يجب ان يكون بعد او في :attribute ',
    'between' => [
        'numeric' => ':min and :max يجب ان يكون بين  :attribute',
        'file' => 'كيلو بايتس :min and :max يجب ان يكون بين :attribute',
        'string' => 'عناصر :min and :max يجب ان يكون بين :attribute',
        'array' => 'عناصر :min and :max يجب ان يكون بين :attribute',
    ],
    'boolean' => 'يجب ان يكون صح او خطأ :attribute',
    'confirmed' => 'غير مقبول :attribute',
    'date' => 'تاريخ غير مسموح :attribute ',
    'date_equals' => ':date يحب ان يكون بتاريخ يساوي :attribute',
    'date_format' => ':format لا يتبع هذا النمط :attribute',
    'different' => 'يجب ان يكونوا مختلفين :other و :attribute',
    'digits' => ' :digits digits يجب ان يكون :attribute',
    'digits_between' => ':min and :max يجب ان يكون بين رقمي  :attribute',
    'dimensions' => 'يحتوي علي مقاسات غير مسموح بها :attribute',
    'distinct' => 'يحتوي علي قيمة مكررة :attribute',
    'email' => 'يجب ان يكون بريد الكتروني مفعل :attribute ',
    'ends_with' => ':values : يجب ان ينتهي بقيمة من القيم التالية  :attribute',
    'exists' => 'المختار غير صالح :attribute',
    'file' => 'لابد ان يكون ملف  :attribute',
    'filled' => 'يجب أن يحتوي علي قيمة :attribute',
    'gt' => [
        'numeric' => ':value يجب أن يكون أكبر من :attribute',
        'file' => 'كيلو بايتس :value يجب أن يكون أكبر من :attribute',
        'string' => 'عناصر :value يجب أن يكون أكبر من أو يساوي :attribute',
        'array' => 'عناصر :value يجب أن يكون أكبر من أو يساوي :attribute',
    ],
    'gte' => [
        'numeric' => ':value يجب أن يكون أكبر من أو يساوي :attribute',
        'file' => ' كيلو بايتس :value يجب أن يكون أكبر من :attribute ',
        'string' => 'عناصر :value يجب أن يكون أكبر من أو يساوي :attribute',
        'array' => 'أو أكثر :value يجب ان يحتوي علي :attribute ',
    ],
    'image' => 'يجب أن يكون صورة :attribute',
    'in' => 'المختار غير صالح :attribute',
    'in_array' => ':other غير موجود في  :attribute',
    'integer' => 'يجب أن يكون رقم صحيح :attribute',
    'ip' => ' صالح للاستخدام IP address يجب أن يكون  :attribute',
    'ipv4' => 'صالح للاستخدام IPv4 address يجب أن يكون  :attribute',
    'ipv6' => 'صالح للاستخدام IPv6 address يجب أن يكون  :attribute',
    'json' => 'صالح للاستخدام  JSON string يجب أن يكون  :attribute',
    'lt' => [
        'numeric' => ':value يجب أن يكون أصغر من أو يساوي :attribute',
        'file' => 'كيلو بايتس :value يجب أن يكون أصغر من :attribute ',
        'string' => 'عناصر :value يجب أن يكون أصغر من أو يساوي :attribute',
        'array' => 'عنصر :value يجب ان يحتوي علي أقل من :attribute ',
    ],
    'lte' => [
        'numeric' => 'أو أقل :value يجب ان يكون :attribute ',
        'file' => 'كيلو بايتس :value يجب أن يكون أصغر من :attribute ',
        'string' => 'عناصر :value يجب أن يكون أصغر من أو يساوي :attribute',
        'array' => 'عنصر :value يجب ان لا يحتوي علي أكثر من :attribute ',
    ],
    'max' => [
        'numeric' => ':max لا يجب أن يكون أكثر من :attribute',
        'file' => 'كيلو بايتس :max يجب الا يكون أكثر من :attribute ',
        'string' => 'عنصر :max يجب الا يكون أكثر من :attribute ',
        'array' => 'عنصر :max يجب الا يكون أكثر من :attribute ',
    ],
    'mimes' => ':values يجب ان يكون ملف بصيغة :attribute',
    'mimetypes' => ':values يجب ان يكون ملف من نوع :attribute',
    'min' => [
        'numeric' => ':min يجب أن يكون علي الأقل  :attribute',
        'file' => 'كيلوبايتس :min يجب أن يكون علي الأقل  :attribute',
        'string' => 'عناصر :min يجب أن يكون علي الأقل  :attribute',
        'array' => 'عناصر :min يجب أن يكون علي الأقل  :attribute',
    ],
    'not_in' => 'المختار غير صالح :attribute',
    'not_regex' => 'غير صالح :attribute صيغة',
    'numeric' => 'يجب أن يكون رقم  :attribute',
    'password' => 'كلمة المرور غير صحيحة',
    'present' => 'The :attribute field must be present.',
    'regex' => 'غير صالحة :attribute طريقة',
    'required' => 'مطلوب :attribute',
    'required_if' => ':value يساوي :other مطلوب عند:attribute ',
    'required_unless' => ':values يوجد في :other مطلوب لحين ان :attribute',
    'required_with' => ':values مطلوب في حضور :attribute ',
    'required_with_all' => ':values مطلوب في حضور :attribute ',
    'required_without' => ':values مطلوب في غياب :attribute ',
    'required_without_all' => ':values مطلوب في غياب كل :attribute',
    'same' => ':other و :attribute يجب تطابق',
    'size' => [
        'numeric' => ':size يجب أن يكون :attribute' ,
        'file' => 'كيلوبايتس :size يجب أن يكون :attribute',
        'string' => 'عناصر :size يجب أن يكون :attribute',
        'array' => 'عناصر :size يجب أن يكون :attribute',
    ],
    'starts_with' => ':values : يجب ان يبدأ بقيمة من هذه القيم  :attribute',
    'string' => 'يجب ان يكون نص كلامي:attribute',
    'timezone' => 'يجب ان يكون نطاق صالح للاستخدام :attribute',
    'unique' => 'مستخدم من قبل :attribute',
    'uploaded' => 'فشل في العملية :attribute',
    'url' => 'غير صالحة :attribute صغية',
    'uuid' => 'صالح للاستخدام UUID يجب أن يكون :attribute ',

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

    'attributes' => require('site.php'),

];
