@extends('layouts.redesign', ["title" => $app->name, "hide_nav" => true ])


@section('content')



<section class="p-0 mt-12">
  <div class="container">
    <div class="row">
      <div class="col-tablet-portrait-6 px-tablet-portrait">
        <div class="bg-white">


          {{-- APPLICATION ICON, TITLE, SHORT, & BUTTONS --}}
          <div class="flex items-start justify-start">
            <img width="60" height="60" src="{{ url($app->icon) }}" alt="" style="border-radius: 1.2rem">
            <div class="ml-3 mt-1 leading-none">
              {{ $app->name }}
              <div class="leading-none">
                <small>{{ $app->short }}</small>
                <br>
                <small>v{{ $app->mirrors[0]->version ?? $app->version ?? "????" }}</small>
              </div>
              <div class="flex items-center justify-start mt-1">
                  @foreach ($app->mirrors as $mirror)
                    @if(!$mirror->provider->revoked)
                      <div class="relative rounded-full border border-gray-100-light overflow-hidden" style="margin-right: 2px">
                          <img class="rounded-full" src="https://avatars.io/twitter/{{ $mirror->provider->twitter }}/20" alt="" width="20">
                      </div>
                    @endif
                  @endforeach
              </div>

              <div class="mt-5">
                @if($app->unsigned)
                @component('components.button', ["href"=> "/download/$app->uid", "bg" => "gray-100", "color" => "blue"])
                IPA @endcomponent
                @endif
                @if($app->mirrors->isNotEmpty())
                  @component('components.button', ["href"=> "/install/mirror/$app->uid/" . $app->mirrors[0]->provider_id, "bg" => "blue", "color" => "white"])
                  GET @endcomponent
                @elseif($app->signed)
                  @component('components.button', ["href"=> "/install/$app->uid", "bg" => "blue", "color" => "white"])
                  GET @endcomponent
                @endif
                @admin
                @component('components.button', ["href"=> "/app/edit/$app->uid", "bg" => "red", "color" => "white"])
                EDIT @endcomponent
                @endadmin
              </div>
            </div>
          </div>


          <br>
          @component('components.ad')@endcomponent
          <br>

          
          @if($app->mirrors->isNotEmpty())
            {{-- APPLICATION PREVIEWS FROM ITUNES --}}
            @if($app->mirrors[0]->images->where('type', 'phone')->isNotEmpty())
              <input id="app-previews-collapse" type="checkbox" class="collapse-check">
              <label for="app-previews-collapse" class="my-2 collapse-label block">
                <div class="flex items-center justify-between">
                  <span class="title">iPhone Previews</span>
                  <i class="fal fa-plus show-closed"></i>
                  <i class="fal fa-minus show-open"></i>
                </div>
              </label>
              <div class="collapse">
                <ul class="overflow-x-auto flex scrolling-touch">
                  @foreach($app->mirrors[0]->images->where('type', 'phone') as $preview)
                    <li class="flex-grow-0 flex-shrink-0 mr-2 rounded-lg" style="width: 200px">
                      <img class="w-full rounded-lg" src="{{ $preview->url }}" alt="">
                    </li>
                    
                  @endforeach
                </ul>
              </div>
              <hr class="border-0 border-b {{ theme('border-gray-200') }}">
            @endif

            {{-- APPLICATION PREVIEWS FROM ITUNES --}}
            @if($app->mirrors[0]->images->where('type', 'ipad')->isNotEmpty())
              <input id="app-ipadpreviews-collapse" type="checkbox" class="collapse-check">
              <label for="app-ipadpreviews-collapse" class="my-2 collapse-label block">
                <div class="flex items-center justify-between">
                  <span class="title">iPad Previews</span>
                  <i class="fal fa-plus show-closed"></i>
                  <i class="fal fa-minus show-open"></i>
                </div>
              </label>
              <div class="collapse">
                <ul class="overflow-x-auto flex scrolling-touch">
                  @foreach($app->mirrors[0]->images->where('type', 'ipad') as $preview)
                    <li class="flex-grow-0 flex-shrink-0 mr-2 rounded-lg" style="width: 200px">
                      <img class="w-full rounded-lg" src="{{ $preview->url }}" alt="">
                    </li>
                    
                  @endforeach
                </ul>
              </div>
              <hr class="border-0 border-b {{ theme('border-gray-200') }}">
            @endif
          @endif

          

          {{-- APPLICATION DESCRIPTION FROM ITUNES --}}
          @if($app->mirrors->isNotEmpty())
            @if($app->mirrors[0]->description)
            <input id="app-description-collapse" type="checkbox" class="collapse-check">
            <label for="app-description-collapse" class="my-2 collapse-label block">
              <div class="flex items-center justify-between">
                <span class="title">Description</span>
                <i class="fal fa-plus show-closed"></i>
                <i class="fal fa-minus show-open"></i>
              </div>
            </label>
            <div class="text-pre collapse">{{ $app->mirrors[0]->description }}</div>
            <hr class="border-0 border-b {{ theme('border-gray-200') }}">
            @endif
          @endif


          {{-- APPLICATION FEATURES --}}
          <input id="app-modifications-collapse" type="checkbox" class="collapse-check">
          <label for="app-modifications-collapse" class="my-2 collapse-label block">
            <div class="flex items-center justify-between">
              <span class="title">Modifications</span>
              <i class="fal fa-plus show-closed"></i>
              <i class="fal fa-minus show-open"></i>

            </div>
          </label>
          <div class="text-pre collapse">{{ $app->description }}</div>
          <hr class="border-0 border-b {{ theme('border-gray-200') }}">


          {{-- APPLICATION MIRRORS --}}
          @if(count($app->mirrors) > 0)
          <input id="app-mirrors-collapse" type="checkbox" class="collapse-check">
          <label for="app-mirrors-collapse" class="my-2 collapse-label block">
            <div class="flex items-center justify-between">
              <span class="title">Mirrors</span>
              <i class="fal fa-plus show-closed"></i>
              <i class="fal fa-minus show-open"></i>

            </div>
          </label>
          <div class="collapse">
            @foreach ($app->mirrors as $mirror)
                <div class="flex items-center justify-between relative py-3 text-xs">
                    @if($mirror->provider->revoked)
                      <div class="absolute left-0 top-0 right-0 bottom-0 bg-yellow-light -z-1"></div>
                    @endif
                    <div class="flex items-center justify-between">
                      <img class="rounded-full border border-gray-100-light" src="https://avatars.io/twitter/{{ $mirror->provider->twitter }}/20" alt="" width="20">
                      <div class="font-semibold ml-2">{{ $mirror->provider->name }}
                        <small>(v{{ $mirror->version ?? "????" }})</small>
                        {{-- @if($mirror->provider->revoked)
                          (REVOKED)
                        @endif --}}
                      </div>
                    </div>
                    @if($mirror->provider->revoked)
                      @component('components.button', ["size" => "xs", "href"=> "/install/mirror/" . $app->uid . "/" . $mirror->provider->id, "bg" => "red", "color" => "white"])
                      TRY @endcomponent
                    @else
                      @component('components.button', ["size" => "xs", "href"=> "/install/mirror/" . $app->uid . "/" . $mirror->provider->id, "bg" => "blue", "color" => "white"])
                      GET @endcomponent
                    @endif
                    
                </div>
            @endforeach
          </div>
          <hr class="border-0 border-b {{ theme('border-gray-200') }}">
          @endif


          {{-- APPLICATON STATS --}}
          <input id="app-stats-collapse" type="checkbox" class="collapse-check">
          <label for="app-stats-collapse" class="my-2 collapse-label block">
            <div class="flex items-center justify-between">
              <span class="title">Stats</span>
              <i class="fal fa-plus show-closed"></i>
              <i class="fal fa-minus show-open"></i>
            </div>
          </label>
          <div class="collapse">
            <div class="flex items-center justify-start">
              <div class="mr-2 flex items-center justify-start">
                <i class="fad fa-eye mr-2 text-center" style="width: 20px;"></i>
                <span>{{ format_int($app->views ?? "0") }}<span>
              </div>
              <div class="mr-2 flex items-center justify-start">
                <i class="fad fa-download mr-2 text-center" style="width: 20px;"></i>
                <span>{{ format_int($app->downloads ?? "0") }}<span>
              </div>
              <div class="mr-2 flex items-center justify-start">
                <i class="fas fa-database mr-2 text-center" style="width: 20px;"></i>
                <span>{{ format_int($app->views ?? "0b", 'file') }}<span>
              </div>
            </div>
          </div>
          <hr class="border-0 border-b {{ theme('border-gray-200') }}">
          <div class="mb-5 show-gt-tablet-portrait"></div>



        </div>
      </div>
      <div class="col-tablet-portrait-6 px-tablet-portrait">
        <div class="h6 display-clear mb-2">
          <strong>Comments</strong>
        </div>
        Comments are comming soon. <br>
        <br>
        <br>
        <br>
        <br>

      </div>
    </div>
  </div>
</section>







@endsection


@section('footer')
<script>
  autocomplete('appsearch', function (e, target, json) {
    var j = []
    json.forEach(app => {
      var a = Object.assign({}, app)
      var match = a.name.toLowerCase().indexOf(target.value.toLowerCase()) !== -1
      if (match) {
        a.name = a.name.split(new RegExp(target.value, 'i')).join('<span class="auto-complete-match"> ' + target
          .value + '</span>')
        j.push(a)
      }
    })
    j.sort((a, b) => {
      if (a.name < b.name)
        return -1;
      if (a.name > b.name)
        return 1;
      return 0;
    })
    return j.slice(0, 10)
  })
</script>
@endsection
