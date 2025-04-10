<style>
    /* Set blue background for the sidebar */
    #layout-menu {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5)
    }

    /* Remove background from non-active menu items */
    .menu-inner .menu-item {
        background: none !important;
        border: none;
    }

    /* Set active menu item with a slightly darker blue shade */
    .menu-item.active>a {
        background-color: #0056b3 !important;
        /* Darker blue for active item */
        color: rgb(243, 241, 233) !important;
        /* Yellow text */
    }

    /* Set default text and icon color */
    .menu-item>a {
        color: rgb(236, 235, 226) !important;
        /* Yellow text */
    }

    /* Set icon color to yellow */
    .menu-item>a .menu-icon {
        color: rgb(243, 242, 238) !important;
        /* Yellow icon */
    }

    /* On hover, change background slightly */
    .menu-item>a:hover {
        background-color: #004494 !important;
        /* Darker blue on hover */
        color: rgb(236, 235, 229) !important;
    }

    /* Remove sidebar shadow */
    .menu-inner-shadow {
        display: none;
    }
    .logo-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
<div class="app-brand demo">
    <a class="app-brand-link">
        <div class="logo-container">
            <img src="/assets/images/logo.png" alt="" width="50" height="50">
            <span class="app-brand-text demo menu-text fw-bold ms-2" style="font-size: 18px; color:rgb(241, 240, 235);">Welcome, Admin!</span>
        </div>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
    </a>
</div>

  

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item  {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div class="text-truncate">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('banner.upload.view') ? 'active' : '' }}">
            <a href="{{ route('banner.upload.view') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-image"></i>
                <div class="text-truncate">Upload Banner</div>
            </a>
        </li>

        {{-- Events created by scm 10.3.2023 --}}
        <li class="menu-item {{ request()->routeIs('event_index') ? 'active' : '' }}">
            <a href="{{ route('event_index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div class="text-truncate">Events</div>
            </a>
        </li>

        {{-- Event End --}}


        <li class="menu-item {{ request()->routeIs(['members.list', 'members.add', 'admin.approve-members']) ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link has-dropdown">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div class="text-truncate">Members</div>
        <i class="bx bx-chevron-down menu-arrow"></i>
    </a>

    <ul class="menu-sub" style="{{ request()->routeIs(['members.list', 'members.add', 'admin.approve-members']) ? 'display: block;' : 'display: none;' }}">
        <!-- Members List -->
        <li class="menu-item {{ request()->routeIs('members.list') ? 'active' : '' }}">
            <a href="{{ route('members.list') }}" class="menu-link">
                <div class="text-truncate">Members List</div>
            </a>
        </li>

        <!-- Add Members -->
        <li class="menu-item {{ request()->routeIs('members.add') ? 'active' : '' }}">
            <a href="{{ route('members.add') }}" class="menu-link">
                <div class="text-truncate">Add Members</div>
            </a>
        </li>

        <!-- Approve Members -->
        @if(session('admin_role') === 'club_administrator')
        <li class="menu-item {{ request()->routeIs('admin.approve-members') ? 'active' : '' }}">
            <a href="{{ route('admin.approve-members') }}" class="menu-link">
                <div class="text-truncate">Approve Member</div>
            </a>
        </li>
        @endif
    </ul>
</li>



<li class="menu-item {{ request()->routeIs('admin.member.lounge') ? 'active' : '' }}">
    <a href="{{ route('admin.member.lounge') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-group"></i>
        <div class="text-truncate">Member Lounge</div>
    </a>
</li>



        {{-- //Member Role --}}

        <li class="menu-item {{ request()->routeIs(['members.list', 'members.add']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link has-dropdown">
                <i class="menu-icon tf-icons bx bx-user-check"></i>
                <div class="text-truncate">Member Role</div>
                <i class="bx bx-chevron-down menu-arrow"></i>
            </a>
            <ul class="menu-sub" style="{{ request()->routeIs(['assign.member', 'members.remove']) ? 'display: block;' : 'display: none;' }}">
                <!-- Members List -->

                <li class="menu-item {{ request()->routeIs('assign.member') ? 'active' : '' }}">
                    <a href="{{ route('assign.member') }}" class="menu-link">
                        <div class="text-truncate">Assign Member</div>
                    </a>
                </li>

                <!-- Add Members -->
                <li class="menu-item {{ request()->routeIs('members.remove') ? 'active' : '' }}">
                    <a href="{{ route('members.remove') }}" class="menu-link">
                        <div class="text-truncate"> Remove Member Role</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- //Member Role End  --}}


     

        <li class="menu-item {{ request()->routeIs('admin.birthday') ? 'active' : '' }}">
            <a href="{{ route('admin.birthday') }}" class="menu-link" title="View Birthdays and Anniversaries">
                <i class="menu-icon tf-icons bx bx-cake"></i>
                <div class="text-truncate">Birthdays and Anniversary</div>
            </a>
        </li>


        <li class="menu-item {{ request()->routeIs('membership.awards.index') ? 'active' : '' }}">
            <a href="{{ route('membership.awards.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-award"></i>
                <div class="text-truncate">Membership Awards</div>
            </a>
        </li>

<li class="menu-item {{ request()->routeIs('admin.banner.clicks') ? 'active' : '' }}">
<a href="{{ route('admin.banner.clicks') }}" 
       class="menu-link d-flex justify-content-between align-items-center"
       title="Banner Click Statistics">
        <span>
            <i class="menu-icon tf-icons bx bx-bar-chart"></i>
            <span class="text-truncate">Banner Click Stats</span>
        </span>
        @if(isset($bannerClickTotal) && $bannerClickTotal > 0)
            <span class="badge bg-warning text-dark ms-2">{{ $bannerClickTotal }}</span>
        @endif
    </a>
</li>

        <li class="menu-item {{ request()->routeIs(['admin.enquiries.index']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link has-dropdown">
                <i class="menu-icon tf-icons bx bx-envelope"></i> <!-- Change icon if needed -->
                <div class="text-truncate">Enquiry Management</div>
                <i class="bx bx-chevron-down menu-arrow"></i> <!-- Dropdown Arrow -->
            </a>
            <ul class="menu-sub" style="{{ request()->routeIs(['admin.enquiries.index']) ? 'display: block;' : 'display: none;' }}">
                <li class="menu-item {{ request()->routeIs('admin.enquiries.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.enquiries.index') }}" class="menu-link">
                        <div class="text-truncate">Membership Enquiries</div>
                    </a>
                </li>
            </ul>
        </li>



        <!-- Settings Menu with Dropdown -->
        <li class="menu-item has-sub {{ request()->routeIs('admin.settings.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i> <!-- Settings Icon -->
                <div class="text-truncate">Settings</div>
                <i class="bx bx-chevron-down menu-arrow"></i> <!-- Dropdown Arrow -->
            </a>
            <ul class="menu-sub" style="{{ request()->routeIs('admin.settings.*') ? 'display: block;' : 'display: none;' }}">
                <!-- Add Setting -->
                <li class="menu-item {{ request()->routeIs('admin.settings.add') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.add') }}" class="menu-link">
                        <div class="text-truncate">Add Setting</div>
                    </a>
                </li>
                <!-- View Setting -->
                <li class="menu-item {{ request()->routeIs('admin.settings.view') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.view') }}" class="menu-link">
                        <div class="text-truncate">View Setting</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-power-off"></i>
                <div class="text-truncate">Logout</div>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>

    </ul>
</aside>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".menu-item .has-dropdown").forEach(function(menu) {
            menu.addEventListener("click", function() {
                let subMenu = this.nextElementSibling;
                if (subMenu.style.display === "block") {
                    subMenu.style.display = "none";
                } else {
                    subMenu.style.display = "block";
                }
            });
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".menu-item.has-sub > .menu-link").click(function(e) {
            e.preventDefault(); // Prevent default action
            $(this).parent().toggleClass("open");
            $(this).next(".menu-sub").slideToggle(); // Toggle submenu visibility
        });
    });
</script>