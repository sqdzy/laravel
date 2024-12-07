<x-mail::message>
<x-mail::panel>
# Добавлен новый комментарий к статье 
Название статьи: "{{$article_name}}"

Тексе комментария: {{$text_comment}}
</x-mail::panel>

<x-mail::button :url="$url">
Accept
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
