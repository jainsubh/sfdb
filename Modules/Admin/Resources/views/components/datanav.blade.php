<li class="nav-item">
    @foreach($datasets as $dataset)
    <li class="nav-item">
        <a class="{{  (strpos(Route::currentRouteName(), 'dataset') === 0 && in_array($dataset->id, Route::current()->parameters())) ? 'open' : '' }}" href="{{ route('dataset.show', $dataset->id) }}">
            <em class="nav-icon fas fa-database"></em>
            <span class="item-name">{{ $dataset->name }}</span>
        </a>
    </li>
    @endforeach
</li>