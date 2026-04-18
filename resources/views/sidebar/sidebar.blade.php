<aside>
    <style>
        :root {
            --sotraco-green: #009640;
            --sotraco-yellow: #FFD100;
            --sotraco-white: #ffffff;
            --sotraco-gray: #f5f5f5;
        }

        /* --- Sidebar --- */
        #sidebar {
            overflow-y: auto;
            max-height: 100vh;
            background: var(--sotraco-white);
            border-right: 3px solid var(--sotraco-green);
        }

        /* --- Scrollbar --- */
        #sidebar::-webkit-scrollbar {
            width: 8px;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background-color: var(--sotraco-green);
            border-radius: 10px;
        }

        #sidebar::-webkit-scrollbar-track {
            background-color: var(--sotraco-gray);
        }

        /* --- Menu --- */
        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu i {
            width: 22px;
            margin-right: 10px;
            color: var(--sotraco-green);
        }

        .sidebar-menu a {
            color: #333;
            font-weight: 500;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            transition: all 0.25s ease;
            text-decoration: none;
        }

        .sidebar-menu a:hover {
            background: var(--sotraco-green);
            color: var(--sotraco-white);
            border-radius: 6px;
        }

        .sidebar-menu a:hover i {
            color: var(--sotraco-yellow);
        }

        /* --- Sous-menus --- */
        .submenu ul {
            list-style: none;
            padding-left: 35px;
            background: var(--sotraco-gray);
        }

        .submenu ul li a {
            padding: 8px 15px;
            font-size: 0.9rem;
        }

        .menu-arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
            color: var(--sotraco-green);
        }

        .submenu.open > a .menu-arrow {
            transform: rotate(90deg);
        }
    </style>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-menu" id="sidebar-menu">
            <ul>

                <!-- Tableau de bord -->
                <li>
                    <a href="/home">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>

                <!-- Administration -->
                <li class="submenu">
                    <a href="#">
                        <i class="fas fa-user-shield"></i>
                        <span>Administration</span>
                        <span class="menu-arrow">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('users.create') }}">
                                <i class="fas fa-user"></i> Utilisateurs
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('roles.create') }}">
                                <i class="fas fa-user-tag"></i> Rôles
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Lignes -->
                <li>
                    <a href="{{ route('lignes.index') }}">
                        <i class="fas fa-route"></i>
                        <span>Lignes</span>
                    </a>
                </li>

                <!-- Bus -->
                <li class="submenu">
                    <a href="#">
                        <i class="fas fa-bus"></i>
                        <span>Bus</span>
                        <span class="menu-arrow">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('buses.index') }}">
                                <i class="fas fa-list"></i> Liste des bus
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Arrêts -->
                <li class="submenu">
                    <a href="#">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Arrêts</span>
                        <span class="menu-arrow">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('arrets.index') }}">
                                <i class="fas fa-list"></i> Liste des arrêts
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Conducteurs -->
                <li class="submenu">
                    <a href="#">
                        <i class="fas fa-id-card"></i>
                        <span>Conducteurs</span>
                        <span class="menu-arrow">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('conducteurs.index') }}">
                                <i class="fas fa-list"></i> Liste des conducteurs
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('conducteurs.create') }}">
                                <i class="fas fa-plus-circle"></i> Ajouter conducteur
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Positions -->
                <li class="submenu">
                    <a href="#">
                        <i class="fas fa-map"></i>
                        <span>Positions</span>
                        <span class="menu-arrow">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('positions.index') }}">
                                <i class="fas fa-list"></i> Historique
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('positions.create') }}">
                                <i class="fas fa-plus-circle"></i> Nouvelle position
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Paramètres -->
                <li>
                    <a href="{{ route('modifierMdp') }}">
                        <i class="fas fa-cogs"></i>
                        <span>Mot de passe</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</aside>
