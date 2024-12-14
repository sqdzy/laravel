<x-mail::message>
# Статистика

Кол-во просмотров статьи: {{ $article_count }} <br>
Кол-во новых комментариев: {{ $comment_count }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
