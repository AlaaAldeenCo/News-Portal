<div class="navbar-bg"></div>
@include('admin.layouts.navbar')
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">{{ __('admin.Stisla') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">{{ __('admin.St') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('admin.Dashboard') }}</li>
            <li class="active">
                <a href="#" class="nav-link "><i class="fas fa-fire"></i><span>{{ __('admin.Dashboard') }}</span></a>

            </li>
            <li class="menu-header">{{ __('admin.Starter') }}</li>
            @if (canAccess(['category index']))
                <li class="{{ setSidebarActive(['admin.category.index']) }}"><a class="nav-link"
                        href="{{ route('admin.category.index') }}"><i class="far fa-square"></i>
                        <span>{{ __('admin.Category') }}</span></a></li>
            @endif


            @if (canAccess(['news index']))
                <li class="dropdown {{ setSidebarActive(['admin.news.*', 'admin.pending.news']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-columns"></i>
                        <span>{{ __('admin.News') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.news.*']) }}"><a class="nav-link"
                                href="{{ route('admin.news.index') }}">{{ __('admin.All News') }}</a></li>
                        <li class="{{ setSidebarActive(['admin.pending.news']) }}"><a class="nav-link"
                                href="{{ route('admin.pending.news') }}">{{ __('admin.All Pending News') }}</a></li>
                    </ul>
                </li>
            @endif


            @if (canAccess(['about index', 'contact index']))
                <li class="dropdown {{ setSidebarActive(['admin.about.index', 'admin.contact.index']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-columns"></i>
                        <span>{{ __('admin.Pages') }}</span></a>
                    <ul class="dropdown-menu">
                        @if (canAccess(['about index', 'about update']))
                            <li class="{{ setSidebarActive(['admin.about.index']) }}"><a class="nav-link"
                                    href="{{ route('admin.about.index') }}">{{ __('admin.About Page') }}</a></li>
                        @endif

                        @if (canAccess(['contact index', 'contact update']))
                            <li class="{{ setSidebarActive(['admin.contact.index']) }}"><a class="nav-link"
                                    href="{{ route('admin.contact.index') }}">{{ __('admin.Contact Page') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif


            @if (canAccess(['social count index']))
                <li
                    class="{{ setSidebarActive(['admin.social-count.*', 'admin.contact-message.*', 'admin.social-count.index']) }}">
                    <a class="nav-link" href="{{ route('admin.social-count.index') }}"><i class="far fa-square"></i>
                        <span>{{ __('admin.Social Count') }}</span></a>
                </li>
            @endif

            @if (canAccess(['contact message index']))
                <li class="{{ setSidebarActive(['admin.contact-message.index']) }}"><a class="nav-link"
                        href="{{ route('admin.contact-message.index') }}"><i class="far fa-square"></i>
                        <span>{{ __('admin.Contact Messages') }}</span>
                        @if ($unreadMessages > 0)
                            <i class="badge bg-danger" style="color: #fff">{{ $unreadMessages }}</i>
                        @endif
                    </a></li>
            @endif

            @if (canAccess(['home section index']))
                <li class="{{ setSidebarActive(['admin.home-section-setting.index']) }}"><a class="nav-link"
                        href="{{ route('admin.home-section-setting.index') }}"><i class="far fa-square"></i>
                        <span>{{ __('admin.Home Section Setting') }}</span></a></li>
            @endif

            @if (canAccess(['languages index']))
                <li class="{{ setSidebarActive(['admin.language.*', 'admin.language.index']) }}"><a class="nav-link"
                        href="{{ route('admin.language.index') }}"><i class="far fa-square"></i>
                        <span>{{ __('admin.Language') }}</span></a></li>
            @endif

            @if (canAccess(['subscribers index']))
                <li class="{{ setSidebarActive(['admin.subscribers.*', 'admin.subscribers.index']) }}"><a
                        class="nav-link" href="{{ route('admin.subscribers.index') }}"><i class="far fa-square"></i>
                        <span>{{ __('admin.Subscribers') }}</span></a></li>
            @endif

            @if (canAccess(['footer index']))
                <li
                    class="dropdown {{ setSidebarActive([
                        'admin.social-link.*',
                        'admin.footer-info.*',
                        'admin.footer-grid-one.*',
                        'admin.footer-grid-two.*',
                        'admin.footer-grid-three.*',
                    ]) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-columns"></i>
                        <span>{{ __('admin.Footer Setting') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.social-link.*']) }}"><a class="nav-link"
                                href="{{ route('admin.social-link.index') }}">{{ __('admin.Social Links') }}</a></li>
                        <li class="{{ setSidebarActive(['admin.footer-info.*']) }}"><a class="nav-link"
                                href="{{ route('admin.footer-info.index') }}">{{ __('admin.Footer Info') }}</a></li>
                        <li class="{{ setSidebarActive(['admin.footer-grid-one.*']) }}"><a class="nav-link"
                                href="{{ route('admin.footer-grid-one.index') }}">{{ __('admin.Footer Grid One') }}</a></li>
                        <li class="{{ setSidebarActive(['admin.footer-grid-two.*']) }}"><a class="nav-link"
                                href="{{ route('admin.footer-grid-two.index') }}">{{ __('admin.Footer Grid Two') }}</a></li>
                        <li class="{{ setSidebarActive(['admin.footer-grid-three.*']) }}"><a class="nav-link"
                                href="{{ route('admin.footer-grid-three.index') }}">{{ __('admin.Footer Grid Three') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (canAccess(['access management index']))
                <li class="dropdown {{ setSidebarActive(['admin.role-users.*', 'admin.role.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-columns"></i>
                        <span>{{ __('admin.Access Management') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.role-users.*']) }}"><a class="nav-link"
                                href="{{ route('admin.role-users.index') }}">{{ __('admin.Users Roles') }}</a></li>
                        <li class="{{ setSidebarActive(['admin.role.*']) }}"><a class="nav-link"
                                href="{{ route('admin.role.index') }}">{{ __('admin.Roles and Permissions') }}</a></li>
                    </ul>
                </li>
            @endif

            @if (canAccess(['settings index']))
                <li class="{{ setSidebarActive(['admin.setting.*', 'admin.setting.index']) }}"><a class="nav-link"
                        href="{{ route('admin.setting.index') }}"><i class="far fa-square"></i>
                        <span>{{ __('admin.Settings') }}</span></a></li>
            @endif

            @if (canAccess(['access management index']))
                <li class="dropdown {{ setSidebarActive(['admin.admin-localization.*', 'admin.frontend-localization.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-columns"></i>
                        <span>{{ __('admin.Localization') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.admin-localization.index']) }}"><a class="nav-link"
                                href="{{ route('admin.admin-localization.index') }}">{{ __('admin.Admin Lang') }}</a></li>
                        <li class="{{ setSidebarActive(['admin.frontend-localization.index']) }}"><a class="nav-link"
                                href="{{ route('admin.frontend-localization.index') }}">{{ __('admin.Frontend Lang') }}</a></li>
                    </ul>
                </li>
            @endif

            {{-- <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Layout</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
                    <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
                    <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
                </ul> --}}
            {{-- </li> --}}

        </ul>

    </aside>
</div>
