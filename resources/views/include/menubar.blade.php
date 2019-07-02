

    <div class="topbar-menu">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    @if(Auth::user()->userType == 'user')
                        {{------------------------------ USER MENU ------------------------------}}
                        <li class="has-submenu">
                            <a href="{{ route('home') }}"><i class="mdi mdi-view-dashboard"></i>Home</a>
                        </li>

                        <li class="has-submenu">
                            <a href="#"> <i class="mdi mdi-chart-donut-variant"></i> My Book Panel <div class="arrow-down"></div></a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('user.book.my_upload_list') }}">My Uploaded Books</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.book.upload') }}">Upload New Book</a>
                                </li>
                            </ul>
                        </li>

                        <li class="has-submenu">
                            <a href="{{ route('collected.show.list') }}"><i class="mdi mdi-view-dashboard"></i>My collected books</a>
                        </li>

                        <li class="has-submenu">
                            <a href="#"> <i class="fas fa-book"></i> Manage Lend Books <div class="arrow-down"></div></a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('lend.pending') }}">Pending Books</a>
                                </li>
                                <li>
                                    <a href="{{ route('lend.history') }}">My Lent History</a>
                                </li>
                            </ul>
                        </li>

                        <li class="has-submenu">
                            <a href="#"> <i class="fas fa-book"></i> Read Book <div class="arrow-down"></div></a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('complete.show.list') }}">Completed Books</a>
                                </li>
                                <li>
                                    <a href="{{ route('wishlist.show.list') }}">Wishlist</a>
                                </li>
                                <li>
                                    <a href="{{ route('reading.show.list') }}">Currently Reading</a>
                                </li>
                            </ul>
                        </li>

                        <li class="has-submenu">
                            <a href="#"> <i class="fas fa-user-friends"></i> Friends<div class="arrow-down"></div></a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('new.request.show') }}">New Friend Request</a>
                                </li>
                                <li>
                                    <a href="{{ route('friends.list') }}">My Friends</a>
                                </li>
                                <li>
                                    <a href="{{ route('users.show') }}">Browse User</a>
                                </li>
                            </ul>
                        </li>
                    @else
                        {{------------------------------- ADMIN MENU ------------------------------}}
                        <li class="has-submenu">
                            <a href="index.html"><i class="mdi mdi-view-dashboard"></i>Dashboard</a>
                        </li>

                        <li class="has-submenu">
                            <a href="#"> <i class="mdi mdi-chart-donut-variant"></i> Book Panel <div class="arrow-down"></div></a>
                            <ul class="submenu">
                                <li>
                                    <a href="charts-flot.html">All books</a>
                                </li>
                                <li>
                                    <a href="charts-morris.html">Upload new book</a>
                                </li>
                            </ul>
                        </li>

                        <li class="has-submenu">
                            <a href="#"> <i class="mdi mdi-chart-donut-variant"></i> Category Panel <div class="arrow-down"></div></a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('admin.category.list') }}">Category List</a>
                                </li>
                            </ul>
                        </li>

                        <li class="has-submenu">
                            <a href="#"> <i class="mdi mdi-chart-donut-variant"></i> Author Panel <div class="arrow-down"></div></a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('admin.author.list') }}">Author List</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

