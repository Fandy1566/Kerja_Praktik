<div class="header">
    <div class="left-side">
        {{$title}}
    </div>
    <div class="right-side">
    <div class="logo-smp" style="overflow: hidden;"><img src="{{Auth::user()->foto_profil <> null ? asset('storage/'.Auth::user()->foto_profil) : asset('image/picture/Logo.png')}}" alt="" {{Auth::user()->foto_profil <> null ? '' : 'style="width: inherit; height: inherit"'}}></div>
        {{ Auth::user()->name }}
    </div>
</div>
<hr id="header-line">