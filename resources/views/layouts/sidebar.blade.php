<!-- Side Menu -->
@if(auth()->check() && auth()->user()->user_type == 1)
<div id="side-bar-menu">
    <div class="side-menu" id="sideMenu">
        <ul class="nav sidebar-menu flex-column list-unstyled w-100 px-3">

            <!-- Visitor Log Sheets -->
            <li class="nav-item">
            <a href="{{ route('visitor.index') }}" class="nav-link text-white mt-5">
                <i class="bi bi-person-lines-fill text-white fs-6 p-2"></i>
                    Visitor Log Sheets
                </a>
            </li>

            <!-- Settings Accordion -->
            <li class="nav-item accordion bg-transparent w-100" id="settingsAccordion">
                <div class="accordion-item bg-transparent border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button bg-transparent text-white collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#settingsCollapse" aria-expanded="false"
                            aria-controls="settingsCollapse">
                            <i class="bi bi-gear fs-5 p-2"></i>
                                Settings
                        </button>
                    </h2>
                    <div id="settingsCollapse" class="accordion-collapse collapse"
                        data-bs-parent="#settingsAccordion">
                        <div class="accordion-body p-0">
                            <ul class="nav flex-column nav-treeview ps-3">
                                <li class="nav-item">
                                    <a href="{{ route('usertype.index') }}" class="nav-link">
                                    <i class="bi bi-people-fill fs-6 p-2 "></i>
                                        User Type
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link">
                                    <i class="bi bi-person-add fs-6 p-2"></i>
                                        User 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('visitortype.index') }}" class="nav-link">
                                    <i class="bi bi-person-badge fs-6 p-2"></i>
                                        Visitor type
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('registered_id.index') }}" class="nav-link">
                                    <i class="bi bi-person-vcard fs-6 p-2"></i>
                                        ID Number
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>

            <!-- Reports -->
            <li class="nav-item">
                <a href="{{ route('reports.index') }}" class="nav-link text-white">
                <i class="bi bi-journals fs-6 p-2"></i>
                    Reports
                </a>
            </li>
        </ul>
    </div>
</div>

@endif