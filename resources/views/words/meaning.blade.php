@if((isset($form_search) && $form_search == 1) || isset($word) || $word == '')
<div class="library-searches">
    <div class="search-block" style="width: 735px">
        {{ Form::open(array('id' => 'wordForm')) }}
            {{ csrf_field() }}
            <input type="text" style="width: 700px" name="search_word" placeholder="Get meaning of any word" value="{{ ($word != ''? $word: '') }}" class="search-input">
            <button type="submit" class="search-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
        {{ Form::close() }}
    </div>
</div>
@endif
@if(isset($word) && $word != '')
<div class="title" style="text-align:left;">       
    <h3 class="word">{{ $word }}</h3>
    @if(isset($phonetic))
        <span class="punctuation">{{ $phonetic }}</span>
    @endif
    @if(isset($meanings))
        @foreach($meanings as $meaning)
            <div class="definition_type">{{ $meaning->partOfSpeech }}</div>
            <ul>
                @if(isset($meaning->definitions))
                    @foreach($meaning->definitions as $definition)
                        <li>{{ $definition->definition }}</li>
                        @if(isset($definition->example))
                            <li style="font-style: italic;">"{{ $definition->example }}"</li>
                        @endif
                    @endforeach
                @endif
            </ul>
        @endforeach
    @endif
</div>
@endif