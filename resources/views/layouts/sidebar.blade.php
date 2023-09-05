<nav id="dashboard__sidebar">
    <div class="dashboard__sidebar--header">
        <h3>
            <a href="{{ route('dashboard') }}"><img src="{{ asset('images/Logo_OneSign.png') }}" alt="logo_oneSign"/></a>
        </h3>
        <strong>
            <a href="{{ route('dashboard') }}"><img class="logo__responsive"
                                                    src="{{ asset('images/Logo_OneSign.png') }}" alt="logo_oneSign"/></a>
        </strong>
    </div>
    <ul class="list-unstyled dashboard__components">
        @php
            $paramsArray = [];
            if (isset($id)) {
                $paramsArray['id'] = $id;
            }

        $listPermissions = \App\Http\Actions\PermissionAction::getAllPermissionsViaUser();
        $loggedUser = \Illuminate\Support\Facades\Auth::user();
        @endphp
        @if(($menu_type ?? '') == 'menu_profile')
            @foreach(config('sidebars.menu_profile') as $menu)
                @php
                    $route = '#';
                    if (isset($menu['url'])) {
                        $route = url($menu['url']);
                    }
                    // else if (isset($menu['route']) && $menu['route'] == 'profile.index') {
                    //    $route = route($menu['route'], ['id' => \Illuminate\Support\Facades\Auth::user()->id]);
                    //}
                    else if (isset($menu['route'])) {
                        $route = route($menu['route'], $paramsArray);
                    }
                @endphp
                @if(! $loggedUser->parent_id || $menu['permission'] == 'pass' || in_array($menu['permission'], $listPermissions))
                    @if(($menu['key'] == 'profile_list') && $loggedUser->parent_id)
                        @continue;
                    @endif
                    <li>
                        <a href="{{ (isset($menu['route']) ?? '#') ? route($menu['route'], $paramsArray) : '#' }}"
                           class="pl-4.5 {{ ($key ?? '') == $menu['key'] ? 'dashboard__press--active' : '' }} dashboard__tooltip">
                            <span class="dashboard__tooltip--text">{{ $menu['name'] ?? '' }}</span>
                            <i class="fa {{ $menu['icon'] ?? '' }} mr-2 dashboard__tooltip"></i>
                            <span class="dashboard__sidebar--title">{{ $menu['name'] ?? '' }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        @else
            @foreach(config('sidebars.menu_sidebars') as $menu)
                @php
                    // get route
                    $route = '#';
                    if (isset($menu['url'])) {
                        $route = url($menu['url']);
                    }
                    //else if (isset($menu['route']) && $menu['route'] == 'profile.index') {
                    //    $route = route($menu['route'], ['id' => \Illuminate\Support\Facades\Auth::user()->id]);
                    //}
                    else if (isset($menu['route'])) {
                        $route = route($menu['route'], $paramsArray);
                    }

                    //add active class
                    $activeClass = '';
                    $isShowSubMenu = false;
                    if (isset($key) && isset($menu['key'])){

                        if ($key == $menu['key']) {
                            if (!isset($menu['children'])) {
                                $activeClass = 'dashboard__press--active';
                            }
                            $isShowSubMenu = true;
                        }
                    }
                    //dump($listPermissions);
                @endphp
                @if(! $loggedUser->parent_id || in_array($menu['permission'],['pass','permission.contracts']) || in_array($menu['permission'], $listPermissions))
                    @if((in_array($menu['key'], ['dashboard_department', 'human-resource_list'])) && $loggedUser->parent_id)
                        @continue;
                    @endif
                    <li>
                        <a href="{{ $route }}"
                           class="pl-4.5 {{ $activeClass }} {{ isset($menu['children']) ? 'sidebar__parent--link' : ''}} dashboard__tooltip {{$menu['key'] == 'dashboard_contract' ? 'd-flex align-items-center' : ''}}">
                            <!-- Tooltip -->
                            <span class="dashboard__tooltip--text">{{ $menu['name'] ?? '' }}</span>
                            <!-- End tooltip -->
                            <i class="fa {{ $menu['icon'] ?? '' }} mr-2 dashboard__tooltip"></i>
                            <span class="dashboard__sidebar--title">{{ $menu['name'] ?? '' }}</span>
                            @if($menu['key'] == 'dashboard_contract')
                            <i class="ml-1 fa fa-angle-down btn__angle--toggle"></i>
                            @endif
                        </a>
                        @if(isset($menu['children']))
                            <div class="{{ $isShowSubMenu ? '' : 'dashboard__children--container' }}">
                                @foreach($menu['children'] as $childrenItem)
                                    @php
                                        //set route for submenu
                                        $routeChildren = '#';
                                        if (isset($childrenItem['url'])) {
                                            $routeChildren = url($childrenItem['url']);
                                        } else if (isset($childrenItem['route'])) {
                                            $routeChildren = route($childrenItem['route']);
                                        }
                                        // add active class into submenu
                                        $activeClassSubMenu = '';
                                        if (isset($child_key)){
                                            if (isset($childrenItem['key']) && $child_key == $childrenItem['key']) {
                                                $activeClassSubMenu = 'dashboard__press--active';
                                            }
                                            $isShowSubMenu = true;
                                        }
                                    @endphp
                                    <a href="{{ $routeChildren  }}"
                                       class="pl-4.5 {{ $activeClassSubMenu }} dashboard__tooltip d-flex align-items-center child__menu--link">
                                        <span class="dashboard__tooltip--text">
                                            {{ $childrenItem['name'] ?? '' }}
                                        </span>
                                        @if($childrenItem['icon'] == 'contact_icon')
                                                <i class="ml-2 mr-1 fa fa-angle-double-right"></i>
                                        @endif
                                        <span class="dashboard__sidebar--title">
                                            {{ $childrenItem['name'] ?? '' }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
</nav>
<script>
    $(document).ready(function () {
        $('.sidebar__parent--link').on('click', function (e) {
            e.preventDefault();
            var btnToggle = $(this).find('.btn__angle--toggle');
            if(btnToggle.hasClass('fa-angle-down')) {
                btnToggle.removeClass('fa-angle-down').addClass('fa-angle-up');
            } else {
                btnToggle.removeClass('fa-angle-up').addClass('fa-angle-down');
            }
            $(this).parent().find('div').slideToggle();
        })
    })
</script>
