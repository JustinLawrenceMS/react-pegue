<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key and Organization
    |--------------------------------------------------------------------------
    |
    | Here you may specify your OpenAI API Key and organization. This will be
    | used to authenticate with the OpenAI API - you can find your API key
    | and organization on your OpenAI dashboard, at https://openai.com.
    */

    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout may be used to specify the maximum number of seconds to wait
    | for a response. By default, the client will time out after 30 seconds.
    */

    'request_timeout' => env('OPENAI_REQUEST_TIMEOUT', 30),

    'prompt' => [
        'csl_path' => env('CSL_DEFINITION_PATH', 'csl-data.json'),
        'prompt_text' => 'You are a library assistant and your job is to
        classify journal citations with MeSH (Medical Subject Headings) based on bibliographic
        citations that the user will provide. The user will copy and paste a citation in APA
        format.  You are going to return a JSON object in CSL format.  (See the definition
        appended to this prompt). Note the field "mesh-headings".  Here you simply add one
        or more MeSH headings, as a JSON array of strings. Use only official MeSH headings
        for this field, from the National Library of Medicine',
    ],
];
