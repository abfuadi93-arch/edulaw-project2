<style>
    :root {
        --edulaw-console-ink: #0f172a;
        --edulaw-console-muted: #64748b;
        --edulaw-console-line: #e2e8f0;
        --edulaw-console-soft: #f8fafc;
        --edulaw-console-blue: #2563eb;
        --edulaw-console-navy: #0b1f4d;
    }

    .fi-body {
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        color: var(--edulaw-console-ink);
    }

    .fi-layout {
        min-height: 100vh;
        background: transparent;
    }

    .fi-topbar > nav {
        height: 64px;
        border-bottom: 1px solid var(--edulaw-console-line);
        background: rgba(255, 255, 255, .92);
        box-shadow: none;
        backdrop-filter: blur(18px);
    }

    .fi-topbar > nav > [x-persist] {
        flex: 1;
        justify-content: flex-start;
        margin-inline-start: 0 !important;
    }

    .fi-topbar > nav > [x-persist] > .fi-global-search {
        margin-inline-end: auto;
    }

    .fi-topbar > nav > [x-persist] > .fi-user-menu {
        margin-inline-start: 0;
    }

    .fi-topbar .fi-global-search-field {
        min-width: min(360px, 36vw);
    }

    .edulaw-topbar-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-inline-start: auto;
    }

    .edulaw-topbar-button,
    .edulaw-topbar-icon-button {
        display: inline-flex;
        height: 36px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        background: #ffffff;
        color: #0f172a;
        font-size: 11px;
        font-weight: 850;
        padding: 0 12px;
        box-shadow: 0 8px 18px rgba(15, 23, 42, .035);
        transition: .18s ease;
    }

    .edulaw-topbar-button:hover,
    .edulaw-topbar-icon-button:hover {
        border-color: #bfdbfe;
        color: #1d4ed8;
    }

    .edulaw-topbar-button-primary {
        border-color: transparent;
        background: #eff6ff;
        color: #1d4ed8;
    }

    .edulaw-topbar-button svg,
    .edulaw-topbar-icon-button svg {
        width: 16px;
        height: 16px;
    }

    .edulaw-topbar-icon-button {
        position: relative;
        width: 36px;
        padding: 0;
    }

    .edulaw-topbar-icon-button span {
        position: absolute;
        right: -5px;
        top: -6px;
        display: inline-flex;
        min-width: 18px;
        height: 18px;
        align-items: center;
        justify-content: center;
        border: 2px solid #ffffff;
        border-radius: 999px;
        background: #e11d48;
        color: #ffffff;
        font-size: 10px;
        font-weight: 900;
        line-height: 1;
    }

    .edulaw-topbar-user-label {
        display: grid;
        min-width: 116px;
        gap: 1px;
    }

    .edulaw-topbar-user-label strong {
        overflow: hidden;
        color: #0f172a;
        font-size: 12px;
        font-weight: 850;
        line-height: 1.2;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .edulaw-topbar-user-label small {
        overflow: hidden;
        color: #64748b;
        font-size: 10px;
        font-weight: 650;
        line-height: 1.2;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .fi-logo {
        color: #020617;
        font-size: 20px;
        font-weight: 900;
        letter-spacing: 0;
        line-height: 1;
        text-transform: uppercase;
    }

    .fi-sidebar .fi-logo {
        color: #ffffff;
    }

    .edulaw-brand-logo {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #ffffff;
        line-height: 1;
    }

    .edulaw-brand-logo-mark {
        display: inline-flex;
        width: 34px;
        height: 34px;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(255, 255, 255, .85);
        border-radius: 10px;
        color: #ffffff;
    }

    .edulaw-brand-logo-mark svg {
        width: 22px;
        height: 22px;
    }

    .edulaw-brand-logo-text {
        display: grid;
        gap: 3px;
    }

    .edulaw-brand-logo-text strong {
        font-size: 18px;
        font-weight: 950;
        letter-spacing: 0;
        text-transform: uppercase;
    }

    .edulaw-brand-logo-text small {
        color: rgba(191, 219, 254, .92);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .fi-sidebar {
        border-right: 0;
        background: #061638;
        box-shadow: 18px 0 40px rgba(15, 23, 42, .08);
    }

    .fi-sidebar-header {
        height: 64px;
        border-bottom: 1px solid rgba(255, 255, 255, .06);
        background: transparent;
    }

    .fi-sidebar-nav {
        padding: 20px 12px;
    }

    .fi-sidebar-group-label {
        color: #ffffff !important;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .06em;
        margin-top: 18px;
        opacity: 1 !important;
    }

    .fi-sidebar-item a {
        border-radius: 8px;
        color: #ffffff !important;
        font-weight: 760;
        font-size: 13px;
        opacity: 1 !important;
    }

    .fi-sidebar-item-label,
    .fi-sidebar-item-label span,
    .fi-sidebar-item a span {
        color: #ffffff !important;
        opacity: 1 !important;
    }

    .fi-sidebar-item-active a,
    .fi-sidebar-item a:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, .28);
    }

    .fi-sidebar-item-icon {
        color: #ffffff !important;
        opacity: 1 !important;
    }

    .fi-sidebar-item a:hover .fi-sidebar-item-icon,
    .fi-sidebar-item-active a .fi-sidebar-item-icon,
    .fi-sidebar-item a:hover .fi-sidebar-item-label,
    .fi-sidebar-item-active a .fi-sidebar-item-label {
        color: #ffffff !important;
        opacity: 1 !important;
    }

    .fi-main {
        background: transparent;
    }

    .fi-main-ctn {
        background: transparent;
    }

    .fi-page {
        gap: 18px;
        padding-top: 18px;
    }

    .fi-header {
        display: none;
    }

    .fi-header-heading {
        color: #020617;
        font-size: clamp(26px, 2.4vw, 34px);
        font-weight: 900;
        letter-spacing: 0;
        line-height: 1.1;
    }

    .fi-header-subheading {
        color: var(--edulaw-console-muted);
        font-size: 15px;
        line-height: 1.6;
        margin-top: 6px;
    }

    .fi-breadcrumbs {
        margin-bottom: 8px;
    }

    .fi-breadcrumbs-item-label {
        color: #64748b;
        font-size: 13px;
        font-weight: 700;
    }

    .fi-section {
        border: 1px solid var(--edulaw-console-line);
        border-radius: 8px;
        background: rgba(255, 255, 255, .96);
        box-shadow: 0 16px 34px rgba(15, 23, 42, .04);
        overflow: visible;
    }

    .fi-section-header {
        border-bottom: 1px solid var(--edulaw-console-line);
        background: rgba(255, 255, 255, .78);
        padding: 18px 20px;
    }

    .fi-section-header-icon {
        color: #2563eb;
    }

    .fi-section-header-heading {
        color: #0f172a;
        font-size: 14px;
        font-weight: 850;
    }

    .fi-section-header-description {
        color: #64748b;
        font-size: 12px;
        line-height: 1.55;
    }

    .fi-section-content {
        padding: 20px;
    }

    .fi-wi-stats-overview-stat,
    .fi-wi-stats-overview-stat > div {
        border-radius: 8px;
    }

    .fi-wi-stats-overview-stat {
        border: 1px solid var(--edulaw-console-line);
        background: #ffffff;
        min-height: 132px;
        padding: 20px !important;
        box-shadow: 0 14px 28px rgba(15, 23, 42, .04);
        overflow: hidden;
    }

    .fi-wi-stats-overview-stat > .grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        grid-template-rows: auto auto;
        align-items: center;
        column-gap: 18px;
    }

    .fi-wi-stats-overview-stat::before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 4px;
        background: #2563eb;
    }

    .fi-wi-stats-overview-stat:nth-child(2)::before {
        background: #22c55e;
    }

    .fi-wi-stats-overview-stat:nth-child(3)::before {
        background: #f97316;
    }

    .fi-wi-stats-overview-stat:nth-child(4)::before {
        background: #7c3aed;
    }

    .fi-wi-stats-overview-stat .fi-wi-stats-overview-stat-icon {
        display: inline-flex;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
        padding: 8px;
    }

    .fi-wi-stats-overview-stat:nth-child(2) .fi-wi-stats-overview-stat-icon {
        background: #dcfce7;
        color: #16a34a;
    }

    .fi-wi-stats-overview-stat:nth-child(3) .fi-wi-stats-overview-stat-icon {
        background: #ffedd5;
        color: #f97316;
    }

    .fi-wi-stats-overview-stat:nth-child(4) .fi-wi-stats-overview-stat-icon {
        background: #f3e8ff;
        color: #7c3aed;
    }

    .fi-wi-stats-overview-stat .fi-wi-stats-overview-stat-label {
        color: #475569;
        font-size: 12px;
        font-weight: 850;
    }

    .fi-wi-stats-overview-stat .fi-wi-stats-overview-stat-label {
        grid-column: 1;
        grid-row: 1;
    }

    .fi-wi-stats-overview-stat .fi-wi-stats-overview-stat-value {
        grid-column: 2;
        grid-row: 1 / span 2;
        justify-self: end;
        margin-top: 2px;
        font-size: 30px;
        font-weight: 950;
        text-align: right;
    }

    .fi-wi-stats-overview-stat .fi-wi-stats-overview-stat-description {
        grid-column: 1;
        grid-row: 2;
        margin-top: 6px;
        font-size: 12px;
    }

    .fi-wi-stats-overview-stat-chart canvas {
        height: 34px !important;
    }

    .fi-ta-ctn {
        background: #ffffff;
        overflow: hidden;
    }

    .fi-ta-content {
        overflow-x: hidden;
    }

    .fi-ta-table {
        min-width: 0 !important;
        table-layout: fixed;
    }

    .fi-ta-cell .fi-ta-text {
        max-width: 100%;
    }

    .fi-wi-table .fi-ta-text {
        min-width: 0;
    }

    .fi-wi-table .fi-ta-text span {
        min-width: 0;
    }

    .fi-wi-table tbody td:first-child .fi-ta-text,
    .fi-wi-table tbody td:first-child .fi-ta-text span {
        display: -webkit-box;
        overflow: hidden;
        white-space: normal;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        line-height: 1.45;
    }

    .fi-wi-table .fi-ta-table thead th {
        font-size: 11px;
        font-weight: 850;
    }

    .fi-wi-table .fi-ta-table tbody td {
        font-size: 12px;
    }

    .fi-wi-table .fi-ta-header-heading {
        font-size: 15px;
    }

    .fi-wi-table .fi-ta-search-field input {
        font-size: 12px;
    }

    .fi-wi-table .fi-badge {
        border-radius: 6px;
        font-size: 11px;
        font-weight: 850;
        padding: 4px 8px;
        white-space: nowrap;
    }

    .fi-wi-table .fi-ta-icon {
        width: 16px;
        height: 16px;
        color: #64748b;
    }

    .fi-ta-table thead th,
    .fi-ta-table tbody td {
        padding-inline: 14px !important;
    }

    .fi-wi-table .fi-ta-content {
        height: 510px;
        max-height: 510px;
        overflow-y: hidden;
    }

    .fi-wi-table .fi-ta-header-toolbar {
        border-bottom: 1px solid #e2e8f0;
        background: #ffffff;
    }

    .fi-wi-table .fi-ta-search-field {
        max-width: 260px;
        margin-inline-start: auto;
    }

    .fi-wi-table .fi-ta-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .fi-resource-categories .fi-ta-ctn {
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
    }

    .fi-resource-categories .fi-ta-content {
        overflow-x: hidden !important;
    }

    .fi-resource-categories .fi-ta-table {
        width: 100% !important;
        min-width: 100% !important;
        table-layout: fixed;
    }

    .fi-resource-categories .fi-table-cell-name .fi-ta-text,
    .fi-resource-categories .fi-table-cell-name .fi-ta-text-item,
    .fi-resource-categories .fi-table-cell-name .fi-ta-text-item-label {
        max-width: 100%;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .fi-resource-categories .fi-ta-actions-cell {
        width: 20%;
        max-width: 160px;
    }

    .fi-resource-categories .fi-ta-actions {
        justify-content: flex-end;
        gap: 8px;
        white-space: nowrap;
    }

    .fi-resource-categories .fi-ta-actions .fi-ac-link-action {
        color: #2563eb;
        font-size: 13px;
        font-weight: 700;
    }

    .fi-resource-categories .fi-ta-actions .fi-ac-link-action:hover {
        color: #1d4ed8;
    }

    .fi-resource-research .fi-ta-ctn {
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
    }

    .fi-resource-research .fi-ta-content {
        overflow-x: hidden !important;
    }

    .fi-resource-research .fi-ta-table {
        width: 100% !important;
        min-width: 100% !important;
        table-layout: fixed;
    }

    .fi-resource-research .fi-table-cell-title .fi-ta-text {
        max-width: 100%;
        min-width: 0;
    }

    .fi-resource-research .fi-table-cell-title .fi-ta-text > div,
    .fi-resource-research .fi-table-cell-title .fi-ta-text-item {
        min-width: 0;
        max-width: 100%;
    }

    .fi-resource-research .fi-table-cell-title .fi-ta-text-item-label {
        display: -webkit-box;
        max-width: 100%;
        overflow: hidden;
        white-space: normal;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-height: 1.35;
        overflow-wrap: anywhere;
    }

    .fi-resource-research .edulaw-publication-meta {
        display: flex;
        min-width: 0;
        max-width: 100%;
        align-items: center;
        gap: 8px;
        overflow: hidden;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
        line-height: 1.4;
    }

    .fi-resource-research .edulaw-publication-meta > span:last-child {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .fi-resource-research .edulaw-publication-pdf-badge {
        flex: 0 0 auto;
        border-radius: 6px;
        padding: 3px 7px;
        font-size: 10px;
        font-weight: 850;
        line-height: 1;
    }

    .fi-resource-research .edulaw-publication-pdf-badge.is-available {
        background: #dcfce7;
        color: #15803d;
    }

    .fi-resource-research .edulaw-publication-pdf-badge.is-missing {
        background: #f1f5f9;
        color: #64748b;
    }

    .fi-resource-research .fi-table-cell-download-count {
        text-align: center;
    }

    .fi-resource-research .fi-ta-actions-cell {
        width: 8%;
        min-width: 80px;
        max-width: 100px;
    }

    .fi-resource-research .fi-ta-actions {
        justify-content: flex-end;
        gap: 8px;
        white-space: nowrap;
    }

    .fi-resource-research .fi-ta-actions .fi-ac-link-action {
        color: #2563eb;
        font-size: 13px;
        font-weight: 700;
    }

    .fi-resource-research .fi-ta-actions .fi-ac-link-action:hover {
        color: #1d4ed8;
    }

    .edulaw-hero-card {
        position: relative;
        display: grid;
        min-height: 140px;
        grid-template-columns: minmax(0, 1fr) 190px;
        gap: 18px;
        align-items: center;
        overflow: hidden;
        border-radius: 8px;
        background:
            radial-gradient(circle at 84% 28%, rgba(37, 99, 235, .22), transparent 18rem),
            radial-gradient(circle at 74% 74%, rgba(14, 165, 233, .12), transparent 15rem),
            linear-gradient(135deg, #f8fbff 0%, #edf5ff 100%);
        padding: 18px 28px;
    }

    .edulaw-hero-copy {
        position: relative;
        z-index: 2;
    }

    .edulaw-eyebrow {
        color: #1d4ed8;
        font-size: 14px;
        font-weight: 850;
    }

    .edulaw-hero-copy h2 {
        margin-top: 14px;
        max-width: 560px;
        color: #020617;
        font-size: 30px;
        font-weight: 900;
        letter-spacing: 0;
        line-height: 1.35;
    }

    .edulaw-hero-copy p:last-child {
        margin-top: 10px;
        max-width: 560px;
        color: #475569;
        font-size: 13px;
        font-weight: 500;
        line-height: 1.7;
    }

    .edulaw-hero-actions {
        position: relative;
        z-index: 2;
        display: grid;
        gap: 8px;
        align-self: center;
    }

    .edulaw-action-button,
    .edulaw-mini-button {
        display: inline-flex;
        min-height: 36px;
        align-items: center;
        justify-content: center;
        gap: 9px;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        background: #ffffff;
        color: #0f172a;
        font-size: 12px;
        font-weight: 850;
        box-shadow: 0 8px 18px rgba(15, 23, 42, .04);
        transition: .18s ease;
    }

    .edulaw-action-button svg,
    .edulaw-mini-button svg {
        width: 16px;
        height: 16px;
    }

    .edulaw-action-button:hover,
    .edulaw-mini-button:hover {
        border-color: #bfdbfe;
        color: #1d4ed8;
    }

    .edulaw-action-button-primary {
        border-color: transparent;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        box-shadow: 0 14px 28px rgba(37, 99, 235, .24);
    }

    .edulaw-action-button-primary:hover {
        color: #ffffff;
        filter: brightness(1.04);
    }

    .edulaw-contributor-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 210px;
        gap: 20px;
        align-items: center;
        border-radius: 8px;
        background: linear-gradient(135deg, #f8fbff 0%, #edf5ff 100%);
        padding: 22px 28px;
    }

    .edulaw-contributor-hero h2 {
        margin-top: 8px;
        color: #0f172a;
        font-size: 24px;
        font-weight: 950;
        letter-spacing: 0;
        line-height: 1.2;
    }

    .edulaw-contributor-hero p:last-child {
        margin-top: 10px;
        max-width: 680px;
        color: #475569;
        font-size: 13px;
        line-height: 1.65;
    }

    .edulaw-contributor-actions {
        display: grid;
        gap: 8px;
    }

    .edulaw-profile-meter {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .edulaw-profile-meter strong {
        color: #0f172a;
        font-size: 34px;
        font-weight: 950;
        line-height: 1;
    }

    .edulaw-profile-meter div {
        flex: 1;
        height: 10px;
        overflow: hidden;
        border-radius: 999px;
        background: #e2e8f0;
    }

    .edulaw-profile-meter span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(135deg, #2563eb, #22c55e);
    }

    .edulaw-profile-checklist {
        display: grid;
        gap: 10px;
        margin-top: 18px;
    }

    .edulaw-profile-checklist div {
        display: grid;
        grid-template-columns: 28px minmax(0, 1fr) auto;
        gap: 10px;
        align-items: center;
        color: #0f172a;
        font-size: 13px;
        font-weight: 800;
    }

    .edulaw-profile-checklist span {
        display: inline-flex;
        width: 24px;
        height: 24px;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
    }

    .edulaw-profile-checklist svg {
        width: 15px;
        height: 15px;
    }

    .edulaw-profile-checklist small {
        color: #64748b;
        font-size: 11px;
        font-weight: 750;
    }

    .edulaw-profile-checklist .is-complete {
        background: #dcfce7;
        color: #16a34a;
    }

    .edulaw-profile-checklist .is-missing {
        background: #fee2e2;
        color: #e11d48;
    }

    .edulaw-next-steps {
        display: grid;
        gap: 14px;
    }

    .edulaw-next-draft {
        display: grid;
        grid-template-columns: 38px minmax(0, 1fr) 18px;
        gap: 12px;
        align-items: center;
        border: 1px solid #dbeafe;
        border-radius: 8px;
        background: #eff6ff;
        padding: 12px;
    }

    .edulaw-next-draft > span {
        display: inline-flex;
        width: 34px;
        height: 34px;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #ffffff;
        color: #2563eb;
    }

    .edulaw-next-draft strong,
    .edulaw-writing-guide strong {
        display: block;
        color: #0f172a;
        font-size: 13px;
        font-weight: 900;
    }

    .edulaw-next-draft small,
    .edulaw-writing-guide span {
        display: block;
        margin-top: 3px;
        overflow: hidden;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.5;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .edulaw-next-step-list {
        display: grid;
        gap: 11px;
    }

    .edulaw-next-step-list p {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #334155;
        font-size: 13px;
        font-weight: 750;
    }

    .edulaw-next-step-list svg {
        width: 17px;
        height: 17px;
        color: #2563eb;
    }

    .edulaw-next-step-list a {
        color: #1d4ed8;
        font-weight: 850;
    }

    .edulaw-writing-guide {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .edulaw-writing-guide div {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #ffffff;
        padding: 14px;
    }

    .edulaw-writing-guide svg {
        width: 24px;
        height: 24px;
        color: #2563eb;
        margin-bottom: 10px;
    }

    .edulaw-contributor-table-card {
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
    }

    .edulaw-contributor-table-scroll {
        overflow-x: auto;
    }

    .edulaw-contributor-articles-widget .fi-ta-ctn,
    .edulaw-contributor-articles-widget .fi-ta-table {
        border: 0 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }

    .edulaw-contributor-articles-widget .fi-ta-content {
        height: auto !important;
        min-height: 0 !important;
        max-height: none !important;
        overflow-x: auto !important;
        overflow-y: visible !important;
    }

    .edulaw-contributor-articles-widget table,
    .edulaw-contributor-articles-widget .fi-ta-table {
        min-width: 100% !important;
        table-layout: fixed;
    }

    .edulaw-contributor-articles-widget thead {
        background: #f9fafb;
    }

    .edulaw-contributor-articles-widget .fi-ta-table thead tr,
    .edulaw-contributor-articles-widget .fi-ta-table tbody tr {
        border-bottom: 1px solid #e5e7eb;
    }

    .edulaw-contributor-articles-widget .fi-ta-table tbody tr:hover {
        background: #f9fafb;
    }

    .edulaw-contributor-articles-widget .fi-ta-table tbody tr:last-child {
        border-bottom: 0;
    }

    .edulaw-contributor-articles-widget .fi-ta-table thead th,
    .edulaw-contributor-articles-widget .fi-ta-table tbody td {
        padding: 12px 14px !important;
        vertical-align: middle;
    }

    .edulaw-contributor-articles-widget tbody td:first-child .fi-ta-text,
    .edulaw-contributor-articles-widget tbody td:first-child .fi-ta-text span {
        display: -webkit-box;
        max-width: 360px;
        overflow: hidden;
        white-space: normal;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-height: 1.45;
    }

    .edulaw-contributor-articles-widget .fi-ta-actions-cell {
        width: 8%;
        white-space: nowrap;
    }

    .edulaw-resource-page {
        display: grid;
        gap: 18px;
    }

    .edulaw-resource-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: center;
        gap: 18px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
        padding: 22px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
    }

    .edulaw-resource-hero span {
        display: inline-flex;
        margin-bottom: 8px;
        color: #2563eb;
        font-size: 11px;
        font-weight: 900;
    }

    .edulaw-resource-hero h1 {
        color: #0f172a;
        font-size: 24px;
        font-weight: 950;
        line-height: 1.2;
        letter-spacing: 0;
    }

    .edulaw-resource-hero p {
        max-width: 660px;
        margin-top: 8px;
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.6;
    }

    .edulaw-resource-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    .edulaw-resource-button {
        display: inline-flex;
        min-height: 38px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        background: #ffffff;
        color: #0f172a;
        padding: 0 13px;
        font-size: 12px;
        font-weight: 850;
        box-shadow: 0 8px 18px rgba(15, 23, 42, .035);
        transition: .18s ease;
    }

    .edulaw-resource-button:hover {
        border-color: #bfdbfe;
        color: #1d4ed8;
    }

    .edulaw-resource-button-primary {
        border-color: transparent;
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 12px 22px rgba(37, 99, 235, .22);
    }

    .edulaw-resource-button-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .edulaw-resource-button svg {
        width: 16px;
        height: 16px;
    }

    .edulaw-insight-summary {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 12px;
    }

    .edulaw-insight-summary-card {
        position: relative;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
        padding: 15px 16px 15px 18px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, .05);
    }

    .edulaw-insight-summary-card::before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 4px;
        background: #2563eb;
    }

    .edulaw-insight-summary-card-gray::before {
        background: #94a3b8;
    }

    .edulaw-insight-summary-card-orange::before {
        background: #f97316;
    }

    .edulaw-insight-summary-card-green::before {
        background: #22c55e;
    }

    .edulaw-insight-summary-card-rose::before {
        background: #f43f5e;
    }

    .edulaw-insight-summary-card span {
        display: block;
        color: #64748b;
        font-size: 11px;
        font-weight: 850;
    }

    .edulaw-insight-summary-card strong {
        display: block;
        margin-top: 7px;
        color: #0f172a;
        font-size: 24px;
        font-weight: 950;
        line-height: 1;
    }

    .edulaw-resource-table-card {
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
    }

    .edulaw-resource-table-scroll {
        overflow-x: visible;
    }

    .edulaw-insight-list-page .fi-ta-ctn,
    .edulaw-insight-list-page .fi-ta-table {
        border: 0 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }

    .edulaw-insight-list-page .fi-ta-content {
        height: auto !important;
        max-height: none !important;
        overflow-x: hidden !important;
        overflow-y: visible !important;
    }

    .edulaw-insight-list-page .fi-ta-table {
        width: 100% !important;
        min-width: 100% !important;
        table-layout: fixed;
    }

    .edulaw-insight-list-page .fi-ta-header-toolbar {
        border-bottom: 1px solid #e5e7eb;
        background: #ffffff;
        padding: 16px 18px;
    }

    .edulaw-insight-list-page .fi-ta-header-heading {
        color: #0f172a;
        font-size: 16px;
        font-weight: 950;
    }

    .edulaw-insight-list-page .fi-ta-header-description {
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .edulaw-insight-list-page .fi-ta-table thead {
        background: #f9fafb;
    }

    .edulaw-insight-list-page .fi-ta-table thead th,
    .edulaw-insight-list-page .fi-ta-table tbody td {
        padding: 13px 14px !important;
        vertical-align: middle;
    }

    .edulaw-insight-list-page .fi-ta-table tbody tr:hover {
        background: #f9fafb;
    }

    .edulaw-insight-list-page .fi-table-cell-title .fi-ta-text {
        max-width: 100%;
        min-width: 0;
    }

    .edulaw-insight-list-page .fi-table-cell-title .fi-ta-text > div {
        min-width: 0;
        max-width: 100%;
    }

    .edulaw-insight-list-page .fi-table-cell-title .fi-ta-text-item {
        max-width: 100%;
        min-width: 0;
    }

    .edulaw-insight-list-page .fi-table-cell-title .fi-ta-text-item-label {
        display: -webkit-box;
        max-width: 100%;
        overflow: hidden;
        white-space: normal;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-height: 1.35;
    }

    .edulaw-insight-list-page .fi-table-cell-title .fi-ta-text p {
        max-width: 100%;
        overflow: hidden;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
        line-height: 1.4;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .edulaw-insight-list-page .fi-ta-actions {
        justify-content: flex-end;
        gap: 0;
        white-space: nowrap;
    }

    .edulaw-insight-list-page .fi-ta-actions-cell {
        width: 104px;
        min-width: 90px;
        max-width: 110px;
    }

    .edulaw-insight-list-page .fi-ta-actions .fi-ac-btn-group {
        min-height: 34px;
        border-radius: 8px;
        background: #2563eb;
        color: #ffffff;
        padding: 8px 12px;
        font-size: 13px;
        font-weight: 850;
    }

    .edulaw-insight-list-page .fi-ta-actions .fi-ac-btn-group:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .edulaw-hero-illustration {
        position: relative;
        height: 238px;
        opacity: .72;
        transform: scale(1.02);
        transform-origin: right center;
    }

    .edulaw-hero-watermark {
        position: absolute;
        right: 236px;
        top: 50%;
        width: 120px;
        height: 120px;
        color: rgba(37, 99, 235, .1);
        transform: translateY(-50%);
        pointer-events: none;
    }

    .edulaw-hero-watermark svg {
        width: 100%;
        height: 100%;
        stroke-width: 1.4;
    }

    .edulaw-columns {
        position: absolute;
        right: -42px;
        top: 22px;
        width: 210px;
        height: 120px;
        border-bottom: 18px solid rgba(30, 64, 175, .08);
        background:
            linear-gradient(90deg, transparent 0 18px, rgba(30, 64, 175, .08) 18px 34px, transparent 34px 52px) 0 28px / 52px 82px repeat-x;
        clip-path: polygon(8% 100%, 92% 100%, 92% 34%, 100% 34%, 50% 0, 0 34%, 8% 34%);
    }

    .edulaw-scale {
        position: absolute;
        right: 70px;
        top: 24px;
        width: 110px;
        height: 120px;
    }

    .edulaw-scale::before {
        content: "";
        position: absolute;
        left: 50%;
        top: 20px;
        width: 8px;
        height: 92px;
        border-radius: 999px;
        background: linear-gradient(180deg, #0f3a72, #2563eb);
        transform: translateX(-50%);
    }

    .edulaw-scale span {
        position: absolute;
        left: 18px;
        top: 34px;
        width: 74px;
        height: 6px;
        border-radius: 999px;
        background: #0f3a72;
    }

    .edulaw-scale i,
    .edulaw-scale b {
        position: absolute;
        top: 56px;
        width: 42px;
        height: 28px;
        border-radius: 0 0 28px 28px;
        border: 2px solid rgba(15, 58, 114, .8);
        border-top: 0;
    }

    .edulaw-scale i {
        left: 0;
    }

    .edulaw-scale b {
        right: 0;
    }

    .edulaw-books {
        position: absolute;
        right: 20px;
        bottom: 12px;
        display: grid;
        gap: 8px;
        width: 190px;
        transform: rotate(-5deg);
    }

    .edulaw-books span {
        display: block;
        height: 28px;
        border-radius: 6px;
        border: 1px solid rgba(30, 64, 175, .2);
        background: linear-gradient(180deg, #ffffff, #dbeafe);
        box-shadow: 0 10px 20px rgba(15, 58, 114, .12);
    }

    .edulaw-books span:nth-child(2) {
        width: 170px;
        margin-left: 15px;
        background: linear-gradient(180deg, #eef6ff, #bfdbfe);
    }

    .edulaw-books span:nth-child(3) {
        width: 150px;
        margin-left: 34px;
        background: linear-gradient(180deg, #0f3a72, #0b2a55);
    }

    .edulaw-security-widget {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 14px;
    }

    .edulaw-security-widget h2 {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #0f172a;
        font-size: 14px;
        font-weight: 900;
        letter-spacing: 0;
    }

    .edulaw-security-widget p {
        margin-top: 8px;
        color: #475569;
        font-size: 12px;
        line-height: 1.6;
    }

    .edulaw-security-icon,
    .edulaw-security-count span {
        display: inline-flex;
        width: 34px;
        height: 34px;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
    }

    .edulaw-security-icon {
        background: #fee2e2;
        color: #e11d48;
    }

    .edulaw-security-icon svg,
    .edulaw-security-count svg {
        width: 18px;
        height: 18px;
    }

    .edulaw-security-counts {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
    }

    .edulaw-security-count {
        display: grid;
        grid-template-columns: 36px 1fr;
        align-items: center;
        gap: 4px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px;
    }

    .edulaw-security-count strong {
        color: #020617;
        font-size: 20px;
        font-weight: 900;
        line-height: 1;
    }

    .edulaw-security-count small {
        grid-column: 2;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
    }

    .edulaw-security-count-critical span {
        background: #fee2e2;
        color: #e11d48;
    }

    .edulaw-security-count-high span {
        background: #fef3c7;
        color: #f59e0b;
    }

    .edulaw-security-count-medium span {
        background: #dbeafe;
        color: #2563eb;
    }

    .edulaw-security-issue {
        border-radius: 8px;
        border-width: 1px;
        padding: 14px;
    }

    .edulaw-security-more {
        display: inline-flex;
        width: 100%;
        min-height: 36px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #ffffff;
        color: #475569;
        font-size: 12px;
        font-weight: 850;
    }

    .edulaw-security-more svg {
        width: 15px;
        height: 15px;
    }

    .edulaw-section-heading {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .edulaw-count-badge {
        display: inline-flex;
        min-width: 22px;
        height: 22px;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #fef3c7;
        color: #d97706;
        font-size: 11px;
        font-weight: 900;
    }

    .edulaw-list-widget {
        display: grid;
        gap: 0;
    }

    .edulaw-queue-row,
    .edulaw-activity-row {
        display: grid;
        align-items: center;
        gap: 14px;
        border-bottom: 1px solid #e2e8f0;
        padding: 14px 0;
    }

    .edulaw-queue-row {
        grid-template-columns: 10px minmax(0, 1fr) auto;
    }

    .edulaw-activity-row {
        grid-template-columns: 32px minmax(0, 1fr) auto;
    }

    .edulaw-queue-row:first-child,
    .edulaw-activity-row:first-child {
        padding-top: 0;
    }

    .edulaw-queue-row:last-child,
    .edulaw-activity-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .edulaw-queue-dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: #fbbf24;
    }

    .edulaw-queue-title,
    .edulaw-activity-copy {
        overflow: hidden;
        color: #0f172a;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.45;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .edulaw-queue-meta,
    .edulaw-activity-title {
        margin-top: 4px;
        overflow: hidden;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .edulaw-status-pill {
        border: 1px solid #fcd34d;
        border-radius: 6px;
        background: #fffbeb;
        color: #d97706;
        padding: 5px 10px;
        font-size: 11px;
        font-weight: 800;
    }

    .edulaw-avatar-mini,
    .edulaw-activity-icon {
        display: inline-flex;
        width: 30px;
        height: 30px;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #dbeafe;
        color: #1e40af;
        font-size: 11px;
        font-weight: 900;
    }

    .edulaw-activity-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .edulaw-activity-icon svg {
        width: 16px;
        height: 16px;
    }

    .edulaw-activity-row time {
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .edulaw-widget-footer {
        display: flex;
        justify-content: center;
        border-top: 1px solid #e2e8f0;
        margin: 18px -20px -20px;
        padding: 16px 20px;
    }

    .edulaw-mini-button {
        min-height: 36px;
        padding: 0 14px;
    }

    .edulaw-mini-button-muted {
        color: #64748b;
        cursor: default;
    }

    .edulaw-empty-state {
        display: grid;
        justify-items: center;
        gap: 8px;
        min-height: 180px;
        align-content: center;
        color: #64748b;
        text-align: center;
    }

    .edulaw-empty-state svg {
        width: 48px;
        height: 48px;
        color: #2563eb;
    }

    .edulaw-empty-state strong {
        color: #0f172a;
        font-size: 14px;
        font-weight: 900;
    }

    .edulaw-empty-state span {
        font-size: 12px;
        font-weight: 500;
    }

    .edulaw-access-list {
        display: grid;
        gap: 0;
    }

    .edulaw-access-item {
        display: grid;
        grid-template-columns: 38px minmax(0, 1fr) 74px;
        gap: 12px;
        align-items: center;
        border-bottom: 1px solid #e2e8f0;
        padding: 15px 0;
    }

    .edulaw-access-item:first-child {
        padding-top: 0;
    }

    .edulaw-access-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .edulaw-access-item span {
        display: inline-flex;
        width: 34px;
        height: 34px;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
    }

    .edulaw-access-item svg {
        width: 17px;
        height: 17px;
    }

    .edulaw-access-item div {
        min-width: 0;
    }

    .edulaw-access-item strong {
        display: block;
        overflow: hidden;
        color: #0f172a;
        font-size: 13px;
        font-weight: 900;
        line-height: 1.25;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .edulaw-access-item small {
        display: block;
        margin-top: 3px;
        overflow: hidden;
        color: #64748b;
        font-size: 11px;
        font-weight: 650;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .edulaw-access-item b {
        display: inline-flex;
        min-height: 42px;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #eef4ff;
        color: #1d4ed8;
        font-size: 18px;
        font-weight: 950;
    }

    .edulaw-access-item-success span {
        background: #dcfce7;
        color: #16a34a;
    }

    .edulaw-access-item-success b {
        background: #e7f8ef;
        color: #16a34a;
    }

    .edulaw-access-item-warning span {
        background: #fff7ed;
        color: #f97316;
    }

    .edulaw-access-item-warning b {
        background: #fff3df;
        color: #f97316;
    }

    .edulaw-access-item-danger span {
        background: #fee2e2;
        color: #e11d48;
    }

    .edulaw-access-item-danger b {
        background: #fee2e2;
        color: #e11d48;
    }

    .edulaw-access-note {
        display: flex;
        align-items: center;
        justify-content: center;
        border-top: 1px solid #e2e8f0;
        margin: 18px -20px -20px;
        padding: 16px 20px;
    }

    .edulaw-access-note p {
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.5;
    }

    .fi-fo-field-wrp-label span {
        color: #0f172a;
        font-weight: 800;
    }

    .fi-fo-field-wrp-helper-text {
        color: #64748b;
        font-size: 12px;
        line-height: 1.55;
    }

    .fi-input-wrp,
    .fi-select-input,
    .fi-ta-textarea,
    .choices__inner,
    .trix-editor,
    .fi-fo-rich-editor-editor {
        border-radius: 8px !important;
        box-shadow: 0 0 0 1px rgba(148, 163, 184, .22), 0 8px 18px rgba(15, 23, 42, .025) !important;
    }

    .fi-select-input,
    .choices__inner {
        min-height: 48px !important;
    }

    .choices__list--single {
        padding-block: 6px !important;
    }

    .choices__placeholder {
        opacity: 1;
    }

    .choices {
        position: relative;
        z-index: 20;
    }

    .choices.is-open {
        z-index: 60;
    }

    .choices__list--dropdown,
    .choices__list[aria-expanded] {
        z-index: 70 !important;
        margin-top: 8px !important;
        border: 1px solid #dbe3ef !important;
        border-radius: 8px !important;
        background: #ffffff !important;
        box-shadow: 0 18px 38px rgba(15, 23, 42, .14) !important;
        overflow: hidden;
    }

    .choices__list--dropdown .choices__item,
    .choices__list[aria-expanded] .choices__item {
        color: #0f172a !important;
        font-size: 14px;
        line-height: 1.45;
        padding: 10px 14px !important;
    }

    .choices__list--dropdown .choices__item--selectable.is-highlighted,
    .choices__list[aria-expanded] .choices__item--selectable.is-highlighted {
        background: #eef4ff !important;
        color: #1d4ed8 !important;
    }

    .fi-input,
    .fi-select-input,
    .fi-ta-textarea {
        color: #0f172a;
    }

    .fi-input::placeholder,
    .fi-ta-textarea::placeholder {
        color: #94a3b8;
    }

    .fi-btn {
        border-radius: 8px;
        font-weight: 800;
    }

    .fi-btn.fi-color-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 16px 34px rgba(37, 99, 235, .22);
    }

    .fi-btn.fi-color-gray {
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
    }

    .fi-form-actions {
        position: sticky;
        bottom: 0;
        z-index: 10;
        margin-top: 20px;
        border-top: 1px solid var(--edulaw-console-line);
        background: linear-gradient(180deg, rgba(248, 250, 252, .78), #f8fafc);
        padding-top: 18px;
        padding-bottom: 8px;
        backdrop-filter: blur(14px);
    }

    .fi-fo-file-upload .filepond--panel-root {
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        background: #f8fafc;
    }

    .fi-ta-table,
    .fi-ta-ctn {
        border-radius: 8px;
        border-color: var(--edulaw-console-line);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .035);
    }

    @media (min-width: 1280px) {
        .fi-main {
            padding-inline: 28px;
        }
    }

    @media (max-width: 1023px) {
        .fi-page {
            padding-top: 18px;
        }

        .fi-section-content,
        .fi-section-header {
            padding: 16px;
        }

        .edulaw-hero-card {
            grid-template-columns: minmax(0, 1fr);
            padding: 18px;
        }

        .edulaw-contributor-hero {
            grid-template-columns: minmax(0, 1fr);
            padding: 18px;
        }

        .edulaw-contributor-actions {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .edulaw-hero-actions {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .edulaw-hero-illustration {
            display: none;
        }

        .edulaw-hero-watermark {
            display: none;
        }

        .edulaw-security-counts {
            grid-template-columns: 1fr;
        }

        .edulaw-access-note {
            align-items: flex-start;
            flex-direction: column;
        }

        .edulaw-writing-guide {
            grid-template-columns: 1fr;
        }

        .edulaw-resource-hero {
            grid-template-columns: minmax(0, 1fr);
        }

        .edulaw-resource-actions {
            justify-content: flex-start;
        }

        .edulaw-insight-summary {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .edulaw-topbar-actions {
            display: none;
        }

        .edulaw-topbar-user-label {
            display: none;
        }

        .fi-topbar > nav > [x-persist] {
            margin-inline-start: auto !important;
        }
    }

    @media (max-width: 640px) {
        .fi-topbar .fi-global-search-field {
            min-width: 0;
            width: 100%;
        }

        .fi-topbar > nav {
            gap: 10px;
            padding-inline: 12px;
        }

        .edulaw-hero-copy h2 {
            font-size: 24px;
        }

        .edulaw-contributor-actions {
            grid-template-columns: 1fr;
        }

        .edulaw-access-list {
            grid-template-columns: 1fr;
        }

        .edulaw-hero-actions {
            grid-template-columns: 1fr;
        }

        .edulaw-activity-row {
            grid-template-columns: 32px minmax(0, 1fr);
        }

        .edulaw-activity-row time {
            grid-column: 2;
        }

        .edulaw-resource-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .edulaw-insight-summary {
            grid-template-columns: 1fr;
        }

        .edulaw-resource-table-scroll {
            overflow-x: auto;
        }

        .edulaw-insight-list-page .fi-ta-content {
            overflow-x: auto !important;
        }

        .edulaw-insight-list-page .fi-ta-table {
            min-width: 720px !important;
        }

        .fi-resource-categories .fi-ta-content {
            overflow-x: auto !important;
        }

        .fi-resource-categories .fi-ta-table {
            min-width: 620px !important;
        }

        .fi-resource-research .fi-ta-content {
            overflow-x: auto !important;
        }

        .fi-resource-research .fi-ta-table {
            min-width: 760px !important;
        }
    }
</style>
