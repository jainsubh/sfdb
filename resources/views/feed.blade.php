<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    @if(count($tasks_completed) > 0)
        @foreach($tasks_completed as $task)
            @if($task->semi_automatic && $task->semi_automatic->status == 'complete')
            <item>
                <guid>{{ $task->semi_automatic->ref_id }}</guid>
                <title>{{ $task->subject->title }}></title>
                <link>{{ route('semi_automatic.download', $task->semi_automatic->ref_id) }}</link>
                <createdBy>{{ $task->completed_by_user->name }}</createdBy>
                <pubDate>{{ $task->completed_at->toRssString() }}</pubDate>
            </item>
            @endif
            @if($task->fully_manual && $task->fully_manual->status == 'complete')
            <item>
                <guid>{{ $task->fully_manual->ref_id }}</guid>
                <title>{{ $task->fully_manual->title }}></title>
                <link>{{ route('fully_manual.download', $task->fully_manual->ref_id) }}</link>
                <createdBy>{{ $task->completed_by_user->name }}</createdBy>
                <pubDate>{{ $task->completed_at->toRssString() }}</pubDate>
            </item>
            @endif
            @if($task->subject_type == 'freeform_report' && $task->subject->status == 'complete')
            <item>
                <guid>{{ $task->subject->ref_id }}</guid>
                <title>{{ $task->subject->title }}></title>
                <link>{{ route('freeform_report.download', $task->subject->ref_id) }}</link>
                <createdBy>{{ $task->completed_by_user->name }}</createdBy>
                <pubDate>{{ $task->completed_at->toRssString() }}</pubDate>
            </item>
            @endif
            @if($task->product && $task->product->status == 'complete')
            <item>
                <guid>{{ $task->product->ref_id }}</guid>
                <title>{{ $task->product->title }}></title>
                <link>{{ route('product.download', $task->product->ref_id) }}</link>
                <createdBy>{{ $task->completed_by_user->name }}</createdBy>
                <pubDate>{{ $task->completed_at->toRssString() }}</pubDate>
            </item>
            @endif
        @endforeach
    @endif
</rss>