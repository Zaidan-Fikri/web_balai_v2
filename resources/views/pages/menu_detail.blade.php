@extends('master.app')

@section('title', $pageTitle . ' - Balai Air Tanah')

@push('styles')
@include('pages.partials.profile_content_styles')
<style>
    .menu-detail-section {
        padding: 56px 0 88px;
        background:
            linear-gradient(180deg, #f4f8ff 0%, #ffffff 42%, #f4f7fb 100%);
    }
    .menu-detail-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 280px;
        gap: 32px;
        align-items: start;
    }
    .menu-detail-main {
        position: relative;
        overflow: hidden;
        min-height: 360px;
        padding: 46px 52px;
        border: 1px solid rgba(0, 51, 153, .08);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 22px 60px rgba(0, 31, 84, .09);
    }
    .menu-detail-main.is-profile {
        background:
            linear-gradient(135deg, rgba(255,255,255,.98), rgba(247,250,255,.98)),
            #fff;
    }
    .menu-detail-main.is-duty {
        background:
            radial-gradient(circle at 88% 10%, rgba(0, 71, 204, .1), transparent 28%),
            radial-gradient(circle at 8% 88%, rgba(22, 163, 232, .1), transparent 30%),
            linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
    }
    .menu-detail-main.is-profile::after {
        content: "BAT";
        position: absolute;
        top: 30px;
        right: 38px;
        color: rgba(0, 51, 153, .035);
        font-size: clamp(4rem, 10vw, 8rem);
        font-weight: 900;
        letter-spacing: .02em;
        line-height: 1;
        pointer-events: none;
    }
    .menu-detail-main.is-duty::after {
        content: "BAT";
        position: absolute;
        top: 34px;
        right: 36px;
        color: rgba(0, 71, 204, .035);
        font-size: clamp(3.8rem, 9vw, 7.4rem);
        font-weight: 900;
        letter-spacing: .02em;
        line-height: 1;
        pointer-events: none;
    }
    .menu-detail-main::before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: 6px;
        background: linear-gradient(90deg, #0047cc, #16a3e8, #f6c34a);
    }
    .menu-detail-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 12px;
        color: #0047cc;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }
    .menu-detail-kicker::before {
        content: "";
        width: 28px;
        height: 2px;
        border-radius: 999px;
        background: #f6c34a;
    }
    .about-heading-row {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 24px;
    }
    .about-heading-copy h2 {
        margin-bottom: 0;
    }
    .about-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 34px;
        padding: 8px 12px;
        border: 1px solid #dce7fb;
        border-radius: 999px;
        background: #fff;
        color: #0047cc;
        font-size: 12px;
        font-weight: 900;
        white-space: nowrap;
        box-shadow: 0 10px 26px rgba(0, 31, 84, .07);
    }
    .about-badge i {
        color: #f6c34a;
    }
    .vision-showcase {
        position: relative;
        z-index: 1;
        display: grid;
        gap: 26px;
    }
    .vision-heading-row {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 28px;
    }
    .vision-heading-row h2 {
        margin-bottom: 0;
    }
    .vision-statement {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: 66px minmax(0, 1fr);
        gap: 20px;
        align-items: start;
        padding: 30px;
        border: 1px solid #dce8fb;
        border-radius: 18px;
        background:
            radial-gradient(circle at 92% 18%, rgba(246, 195, 74, .16), transparent 30%),
            linear-gradient(135deg, rgba(0, 71, 204, .08), rgba(255,255,255,.98) 48%),
            #fff;
        box-shadow: 0 22px 52px rgba(0, 31, 84, .1);
    }
    .vision-statement::before {
        content: "";
        position: absolute;
        top: 22px;
        left: 0;
        width: 5px;
        height: calc(100% - 44px);
        border-radius: 0 999px 999px 0;
        background: linear-gradient(180deg, #0047cc, #16a3e8);
    }
    .vision-statement::after {
        content: "";
        position: absolute;
        inset: auto 24px 0;
        height: 4px;
        border-radius: 999px 999px 0 0;
        background: linear-gradient(90deg, #0047cc, #16a3e8, #f6c34a);
    }
    .vision-icon {
        width: 66px;
        height: 66px;
        display: grid;
        place-items: center;
        border-radius: 20px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: 24px;
        box-shadow: 0 18px 34px rgba(0, 71, 204, .2);
    }
    .vision-label,
    .mission-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 10px;
        color: #0047cc;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }
    .vision-label::before,
    .mission-label::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #f6c34a;
        box-shadow: 0 0 0 4px #fff6dc;
    }
    .vision-statement p {
        margin: 0;
        max-width: 850px;
        color: #0a1f44;
        font-size: clamp(1.12rem, 1.55vw, 1.34rem);
        font-weight: 800;
        line-height: 1.78;
    }
    .vision-keypoints {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin: 18px 0 0;
        padding: 0;
        list-style: none;
    }
    .vision-keypoints li {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 34px;
        padding: 8px 12px;
        border: 1px solid #dce8fb;
        border-radius: 999px;
        background: rgba(255,255,255,.78);
        color: #0a1f44;
        font-size: 12px;
        font-weight: 900;
        box-shadow: 0 8px 20px rgba(0, 31, 84, .05);
    }
    .vision-keypoints i {
        color: #0047cc;
        font-size: 12px;
    }
    .mission-panel {
        position: relative;
        padding: 4px 0 0;
    }
    .mission-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 14px;
    }
    .mission-count {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 32px;
        padding: 7px 11px;
        border: 1px solid #e1eafe;
        border-radius: 999px;
        background: #fff;
        color: #5f6c7b;
        font-size: 12px;
        font-weight: 900;
        white-space: nowrap;
    }
    .mission-count strong {
        color: #0047cc;
    }
    .mission-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        margin: 0;
        padding: 0;
        list-style: none;
        counter-reset: mission-list;
    }
    .mission-card {
        counter-increment: mission-list;
        position: relative;
        overflow: hidden;
        min-height: 126px;
        padding: 22px 18px 20px 78px;
        border: 1px solid #e1eafe;
        border-radius: 16px;
        background:
            linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        color: #475467;
        line-height: 1.72;
        box-shadow: 0 14px 32px rgba(0, 31, 84, .06);
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .mission-card:nth-child(2n) .mission-icon {
        background: linear-gradient(135deg, #0f766e, #16a3e8);
    }
    .mission-card:nth-child(3n) .mission-icon {
        background: linear-gradient(135deg, #7c3aed, #0047cc);
    }
    .mission-card:nth-child(4n) .mission-icon {
        background: linear-gradient(135deg, #0f766e, #22c55e);
    }
    .mission-card:nth-child(5n) .mission-icon {
        background: linear-gradient(135deg, #b45309, #f6c34a);
    }
    .mission-card:nth-child(6n) .mission-icon {
        background: linear-gradient(135deg, #0a1f44, #0047cc);
    }
    .mission-card::before {
        content: counter(mission-list, decimal-leading-zero);
        position: absolute;
        top: 14px;
        right: 16px;
        width: 34px;
        height: 28px;
        display: grid;
        place-items: center;
        border-radius: 999px;
        background: #eef4ff;
        color: #0047cc;
        font-size: 11px;
        font-weight: 900;
    }
    .mission-card::after {
        content: "";
        position: absolute;
        left: 39px;
        top: 70px;
        bottom: 18px;
        width: 2px;
        border-radius: 999px;
        background: #f6c34a;
        opacity: .85;
    }
    .mission-card:hover {
        transform: translateY(-3px);
        border-color: #c8dcff;
        box-shadow: 0 20px 42px rgba(0, 31, 84, .1);
    }
    .mission-icon {
        position: absolute;
        top: 22px;
        left: 20px;
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        border-radius: 14px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: 15px;
        box-shadow: 0 12px 24px rgba(0, 71, 204, .16);
    }
    .mission-card span:last-child {
        position: relative;
        z-index: 1;
        display: block;
        padding-right: 18px;
        color: #344054;
        font-weight: 650;
    }
    .duty-showcase {
        position: relative;
        z-index: 1;
        display: grid;
        gap: 22px;
    }
    .duty-law-card {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: 52px minmax(0, 1fr);
        gap: 16px;
        align-items: start;
        padding: 22px 24px;
        border: 1px solid #dce8fb;
        border-radius: 16px;
        background:
            linear-gradient(135deg, rgba(0, 71, 204, .07), rgba(255,255,255,.98) 48%),
            #fff;
        box-shadow: 0 18px 42px rgba(0, 31, 84, .08);
    }
    .duty-law-card::after {
        content: "";
        position: absolute;
        inset: auto 22px 0;
        height: 4px;
        border-radius: 999px 999px 0 0;
        background: linear-gradient(90deg, #0047cc, #16a3e8, #f6c34a);
    }
    .duty-law-icon,
    .duty-task-icon {
        width: 52px;
        height: 52px;
        display: grid;
        place-items: center;
        border-radius: 17px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: 19px;
        box-shadow: 0 14px 28px rgba(0, 71, 204, .18);
    }
    .duty-small-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 8px;
        color: #0047cc;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }
    .duty-small-label::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #f6c34a;
        box-shadow: 0 0 0 4px #fff6dc;
    }
    .duty-law-card p,
    .duty-task-card p {
        margin: 0;
        max-width: 900px;
        color: #344054;
        font-size: .98rem;
        font-weight: 700;
        line-height: 1.85;
    }
    .duty-task-card {
        display: grid;
        grid-template-columns: 52px minmax(0, 1fr);
        gap: 16px;
        align-items: start;
        padding: 22px 24px;
        border: 1px solid #e1eafe;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 14px 34px rgba(0, 31, 84, .06);
    }
    .duty-task-icon {
        background: linear-gradient(135deg, #0f766e, #16a3e8);
    }
    .function-panel {
        display: grid;
        gap: 14px;
        padding-top: 4px;
    }
    .function-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }
    .function-count {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 32px;
        padding: 7px 11px;
        border: 1px solid #e1eafe;
        border-radius: 999px;
        background: #fff;
        color: #5f6c7b;
        font-size: 12px;
        font-weight: 900;
        white-space: nowrap;
    }
    .function-count strong {
        color: #0047cc;
    }
    .function-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin: 0;
        padding: 0;
        list-style: none;
        counter-reset: function-list;
    }
    .function-card {
        counter-increment: function-list;
        position: relative;
        overflow: hidden;
        min-height: 102px;
        padding: 18px 18px 18px 68px;
        border: 1px solid #e1eafe;
        border-radius: 15px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        color: #344054;
        font-size: .94rem;
        font-weight: 650;
        line-height: 1.72;
        box-shadow: 0 12px 28px rgba(0, 31, 84, .055);
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .function-card::before {
        content: counter(function-list, decimal-leading-zero);
        position: absolute;
        top: 18px;
        left: 18px;
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: #eef4ff;
        color: #0047cc;
        font-size: 11px;
        font-weight: 900;
    }
    .function-card::after {
        content: "";
        position: absolute;
        left: 34px;
        top: 62px;
        bottom: 18px;
        width: 2px;
        border-radius: 999px;
        background: #f6c34a;
    }
    .function-card:hover {
        transform: translateY(-2px);
        border-color: #c8dcff;
        box-shadow: 0 18px 38px rgba(0, 31, 84, .09);
    }
    .menu-detail-main h2 {
        margin: 0 0 22px;
        color: #0a1f44;
        font-size: clamp(1.9rem, 2.8vw, 2.75rem);
        font-weight: 900;
        line-height: 1.2;
    }
    .menu-detail-main p {
        max-width: 860px;
        margin: 0;
        color: #5f6c7b;
        font-size: .96rem;
        line-height: 1.8;
    }
    .menu-detail-body {
        max-width: 920px;
        color: #475467;
        font-size: 1rem;
        line-height: 1.95;
        white-space: normal;
    }
    .menu-detail-main.is-profile .menu-detail-body {
        position: relative;
        max-width: 940px;
        padding: 0 0 0 22px;
        border-left: 3px solid #e8eefb;
    }
    .about-intro-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 260px;
        gap: 28px;
        align-items: start;
    }
    .about-highlight {
        position: relative;
        padding: 20px;
        border: 1px solid #dfe9fb;
        border-radius: 16px;
        background:
            linear-gradient(180deg, #ffffff 0%, #f7faff 100%);
        box-shadow: 0 16px 34px rgba(0, 31, 84, .08);
    }
    .about-highlight-icon {
        width: 38px;
        height: 38px;
        display: grid;
        place-items: center;
        margin-bottom: 10px;
        border-radius: 13px;
        background: #0047cc;
        color: #fff;
        box-shadow: 0 12px 24px rgba(0, 71, 204, .18);
    }
    .about-highlight::before {
        content: "";
        position: absolute;
        top: 18px;
        left: 20px;
        width: 34px;
        height: 3px;
        border-radius: 999px;
        background: #f6c34a;
    }
    .about-highlight h3 {
        margin: 0 0 10px;
        color: #0a1f44;
        font-size: 1.05rem;
        font-weight: 900;
    }
    .about-highlight p {
        margin: 0 0 14px;
        color: #667085;
        font-size: .86rem;
        line-height: 1.7;
    }
    .about-highlight-list {
        display: grid;
        gap: 9px;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .about-highlight-list li {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #0a1f44;
        font-size: .82rem;
        font-weight: 800;
    }
    .about-highlight-list i {
        width: 26px;
        height: 26px;
        display: grid;
        place-items: center;
        border-radius: 9px;
        background: #eef4ff;
        color: #0047cc;
        font-size: 12px;
        flex: 0 0 auto;
    }
    .menu-detail-body p {
        margin: 0 0 18px;
        color: #475467;
        font-size: 1rem;
        line-height: 1.95;
    }
    .menu-detail-body p:last-child {
        margin-bottom: 0;
    }
    .menu-detail-body h3 {
        margin: 28px 0 12px;
        color: #0a1f44;
        font-size: 1.14rem;
        font-weight: 900;
        line-height: 1.35;
    }
    .menu-detail-body h3.profile-section-title {
        display: block;
        margin: 30px 0 12px;
        padding: 0;
        color: #0a1f44;
        font-size: 1.14rem;
    }
    .menu-detail-body h3.profile-section-title::before {
        content: none;
    }
    .menu-detail-body ul,
    .menu-detail-body ol {
        margin: 12px 0 22px;
        padding-left: 22px;
    }
    .menu-detail-body li {
        padding: 0 0 8px 4px;
        border: 0;
        border-radius: 0;
        background: transparent;
        color: #475467;
        line-height: 1.75;
    }
    .menu-detail-body li::before {
        content: none;
    }
    .profile-info-strip {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 38px;
        padding-top: 28px;
        border-top: 1px solid #e6edf8;
    }
    .profile-info-item {
        position: relative;
        overflow: hidden;
        padding: 20px 18px 18px 62px;
        border-radius: 14px;
        background: linear-gradient(180deg, #ffffff 0%, #f7faff 100%);
        border: 1px solid #e1eafe;
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .profile-info-item::before {
        content: attr(data-index);
        position: absolute;
        top: 12px;
        right: 14px;
        color: rgba(0, 71, 204, .12);
        font-size: 1.55rem;
        font-weight: 900;
        line-height: 1;
    }
    .profile-info-item::after {
        content: "";
        position: absolute;
        inset: auto 16px 0 62px;
        height: 3px;
        border-radius: 999px 999px 0 0;
        background: linear-gradient(90deg, #0047cc, #16a3e8);
        opacity: .22;
    }
    .profile-info-item:hover {
        transform: translateY(-2px);
        border-color: #c6d8ff;
        box-shadow: 0 14px 30px rgba(0, 31, 84, .09);
    }
    .profile-info-icon {
        position: absolute;
        top: 18px;
        left: 18px;
        width: 34px;
        height: 34px;
        border-radius: 12px;
        background: #0047cc;
        color: #fff;
        box-shadow: 0 10px 22px rgba(0, 71, 204, .18);
    }
    .profile-info-icon i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 14px;
        line-height: 1;
    }
    .profile-info-item strong {
        display: block;
        margin-bottom: 5px;
        color: #0a1f44;
        font-size: 13px;
        font-weight: 900;
    }
    .profile-info-item span {
        display: block;
        color: #667085;
        font-size: 12px;
        line-height: 1.55;
    }
    /* ── Profile Sidebar (gaya seragam dengan Informasi Publik) ── */
    .profile-sidebar {
        position: sticky;
        top: 96px;
        padding: 0;
        border: 1px solid #e8edf4;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 24px rgba(10,38,71,.10), 0 1px 4px rgba(10,38,71,.06);
        overflow: hidden;
    }
    .profile-sidebar-header {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 22px 18px;
        background: linear-gradient(135deg, #0f2d5a 0%, #1a6bcc 100%);
        overflow: hidden;
    }
    .profile-sidebar-header::after {
        content: 'PROFIL';
        position: absolute;
        right: -10px; top: 50%;
        transform: translateY(-50%);
        font-size: 1.9rem;
        font-weight: 900;
        color: rgba(255,255,255,.06);
        letter-spacing: .04em;
        pointer-events: none;
        white-space: nowrap;
    }
    .profile-sidebar-title {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #fff;
        font-size: .78rem;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
        line-height: 1;
    }
    .profile-sidebar-title::before {
        content: '';
        flex-shrink: 0;
        width: 4px;
        height: 22px;
        background: linear-gradient(180deg, #f0b429, #f97316);
        border-radius: 3px;
    }
    /* Menu list */
    .profile-menu {
        margin: 0;
        padding: 10px 0 6px;
        list-style: none;
    }
    .profile-menu li + li .profile-menu-link::before {
        content: '';
        position: absolute;
        top: 0; left: 22px; right: 22px;
        height: 1px;
        background: #f0f2f6;
    }
    .profile-menu-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 22px;
        font-size: .9rem;
        font-weight: 500;
        color: #445577;
        text-decoration: none;
        transition: background .18s, color .18s, padding-left .18s;
        border-left: 3px solid transparent;
        position: relative;
    }
    .profile-menu-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        background: #f0f4fb;
        display: flex; align-items: center; justify-content: center;
        font-size: .78rem;
        color: #6b84b0;
        flex-shrink: 0;
        transition: background .18s, color .18s;
    }
    .profile-menu-text { flex: 1; line-height: 1.3; }
    .profile-menu-arrow {
        font-size: .65rem;
        color: #c0cce0;
        flex-shrink: 0;
        transition: color .18s, transform .18s;
    }
    .profile-menu-link:hover {
        background: #f4f7ff;
        color: #1a6bcc;
        padding-left: 26px;
        border-left-color: #c5d8f5;
    }
    .profile-menu-link:hover .profile-menu-icon { background: #dde9fb; color: #1a6bcc; }
    .profile-menu-link:hover .profile-menu-arrow { color: #1a6bcc; transform: translateX(2px); }
    .profile-menu-link.is-active {
        background: linear-gradient(90deg, #e8f0fe, #f0f5ff);
        color: #1a6bcc;
        font-weight: 700;
        border-left-color: #1a6bcc;
        padding-left: 26px;
    }
    .profile-menu-link.is-active .profile-menu-icon { background: #1a6bcc; color: #fff; }
    .profile-menu-link.is-active .profile-menu-arrow { color: #1a6bcc; transform: translateX(2px); }
    @media (max-width: 991px) {
        .menu-detail-layout { grid-template-columns: 1fr; }
        .profile-sidebar { position: relative; top: auto; order: -1; }
        .about-intro-grid { grid-template-columns: 1fr; }
        .about-heading-row { align-items: flex-start; flex-direction: column; }
        .vision-heading-row { align-items: flex-start; flex-direction: column; }
        .mission-panel-head { align-items: flex-start; flex-direction: column; }
        .mission-grid { grid-template-columns: 1fr; }
        .function-panel-head { align-items: flex-start; flex-direction: column; }
        .function-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 560px) {
        .menu-detail-section { padding: 36px 0 64px; }
        .menu-detail-main { padding: 26px 22px; }
        .menu-detail-main.is-profile .menu-detail-body { padding-left: 0; border-left: 0; }
        .profile-info-strip { grid-template-columns: 1fr; }
        .about-highlight { padding: 18px; }
        .vision-statement {
            grid-template-columns: 1fr;
            padding: 22px;
        }
        .mission-card {
            min-height: auto;
            padding: 76px 16px 18px 18px;
        }
        .mission-card::before {
            top: 22px;
            left: 66px;
            right: auto;
        }
        .mission-card::after {
            display: none;
        }
        .mission-card span:last-child {
            padding-right: 0;
        }
        .duty-law-card,
        .duty-task-card {
            grid-template-columns: 1fr;
            padding: 20px;
        }
        .function-card {
            min-height: auto;
            padding-right: 16px;
        }
    }
    /* ===== Org Chart ===== */
    .org-wrap {
        overflow-x: auto;
        padding: 32px 24px 28px;
        text-align: center;
        background: radial-gradient(ellipse 80% 60% at 50% 10%, #dbeafe 0%, #eff6ff 45%, #f8faff 100%);
        border-radius: 14px;
        margin-top: 10px;
    }
    .org-tree,
    .org-children {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .org-tree {
        display: inline-flex;
        min-width: max-content;
    }
    .org-tree > .org-item > .org-vline:first-child { display: none; }
    .org-item {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        padding: 0 12px;
    }
    .org-vline {
        width: 2px;
        height: 22px;
        background: #2563eb;
        flex-shrink: 0;
    }
    .org-children {
        display: inline-flex;
        flex-direction: row;
        align-items: flex-start;
    }
    .org-children > .org-item::before,
    .org-children > .org-item::after {
        content: '';
        position: absolute;
        top: 0;
        height: 2px;
        background: #2563eb;
        width: 50%;
    }
    .org-children > .org-item::before { right: 50%; }
    .org-children > .org-item::after  { left: 50%;  }
    .org-children > .org-item:first-child::before,
    .org-children > .org-item:only-child::before { display: none; }
    .org-children > .org-item:last-child::after,
    .org-children > .org-item:only-child::after  { display: none; }
    .org-node-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        --nc: #0047cc;
    }
    .org-avatar {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: var(--nc);
        display: grid;
        place-items: center;
        color: #fff;
        font-size: 19px;
        font-weight: 900;
        border: 3px solid #fff;
        box-shadow: 0 6px 20px rgba(0,0,0,.2);
        position: relative;
        z-index: 2;
        margin-bottom: -14px;
        flex-shrink: 0;
    }
    .org-card {
        position: relative;
        z-index: 1;
        min-width: 136px;
        max-width: 200px;
        padding: 20px 14px 11px;
        border: 2.5px solid var(--nc, #0047cc);
        border-radius: 10px;
        background: #fff;
        text-align: center;
        box-shadow: 0 8px 24px rgba(0,0,0,.09);
    }
    .org-name {
        display: block;
        color: #0a1f44;
        font-size: 12px;
        font-weight: 900;
        line-height: 1.5;
        margin-bottom: 8px;
    }
    .org-pos {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 5px;
        background: var(--nc, #0047cc);
        color: #fff;
        font-size: 9.5px;
        font-weight: 800;
        line-height: 1.45;
        max-width: 100%;
        word-break: break-word;
        white-space: normal;
    }
    .org-standalone-section {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 30px;
        padding-top: 24px;
        border-top: 2px dashed #c8d7f4;
    }
    .org-standalone-pill {
        padding: 14px 34px;
        border-radius: 999px;
        color: #fff;
        font-size: 14px;
        font-weight: 900;
        text-align: center;
        box-shadow: 0 8px 24px rgba(0,0,0,.14);
        border: 2px solid rgba(255,255,255,.2);
    }
    .org-empty-state {
        display: grid;
        place-items: center;
        min-height: 200px;
        border: 1.5px dashed #c8d7f4;
        border-radius: 16px;
        background: #f7faff;
        color: #8290a3;
        font-weight: 800;
        text-align: center;
        padding: 32px;
    }
    /* ===== Spine Org Chart ===== */
    .spine-wrap { overflow-x: auto; padding: 12px 0; }
    /* spine-outer: the container — spine line is drawn via JS-set CSS vars */
    .spine-outer {
        position: relative;
        min-width: 640px;
        max-width: 960px;
        margin: 0 auto;
    }
    /* Continuous vertical spine */
    .spine-outer::before {
        content: '';
        position: absolute;
        top: var(--spine-top, 0);
        bottom: var(--spine-bottom, 0);
        left: 50%;
        width: 2px;
        background: #2563eb;
        transform: translateX(-50%);
        z-index: 0;
        pointer-events: none;
    }
    /* Rows */
    .spine-row {
        display: flex;
        align-items: center;
        position: relative;
        z-index: 1;
    }
    /* Center rows: just centre the node over the spine */
    .spine-row.center-row { justify-content: center; padding: 8px 0; }
    /* Branch rows: two halves, spine sits exactly at the boundary */
    .spine-row.branch-row { padding: 18px 0; }
    /* "Behind" row — rendered overlapping/behind the next center card */
    .spine-row-behind {
        position: relative;
        z-index: 1;
        margin-bottom: -38px;   /* pull next row up to create vertical overlap */
    }
    .spine-row-behind .spine-ctr-cell {
        transform: translateX(-80px);
    }
    /* Push text to the top so it stays visible above the overlapping card */
    .spine-row-behind .spine-node {
        padding-top: 8px;
        padding-bottom: 30px;
    }
    /* The row immediately after a behind row sits on top, shifted right */
    .spine-row-behind + .spine-row.center-row {
        position: relative;
        z-index: 3;
    }
    .spine-row-behind + .spine-row.center-row .spine-ctr-cell {
        transform: translateX(50px);
    }
    /* Spacer in center rows (fills left/right so node stays centered) */
    .spine-spacer { flex: 1; }
    /* Center cell just wraps the node */
    .spine-ctr-cell { display: flex; justify-content: center; }
    /* Two halves for branch rows */
    .spine-half {
        flex: 1;
        display: flex;
        align-items: center;
    }
    /* Left half: node first (left edge), then hline stretches to spine */
    .spine-half.left { flex-direction: row; }
    /* Right half: hline stretches from spine, then node (right edge) */
    .spine-half.right { flex-direction: row; }
    .spine-half-empty { min-height: 76px; }
    /* Node card */
    .spine-node {
        position: relative; z-index: 1;
        min-width: 200px; max-width: none;
        padding: 14px 18px;
        background: linear-gradient(145deg, #1e3faf 0%, #2563eb 100%);
        color: #fff;
        border-radius: 14px; text-align: center;
        border: 1.5px solid rgba(255,255,255,.22);
        box-shadow:
            0 10px 32px rgba(30,64,175,.4),
            0 2px 8px rgba(30,64,175,.2),
            inset 0 1px 0 rgba(255,255,255,.18);
        word-break: break-word; flex-shrink: 0;
        overflow: visible;
        transition: transform .2s, box-shadow .2s;
    }
    .spine-node.has-avatar {
        display: flex; align-items: center; gap: 14px;
        text-align: left; padding: 16px 18px;
    }
    .spine-node-content { flex: 1; min-width: 0; }
    /* Subtle highlight stripe at top of each card */
    .spine-node::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, rgba(255,255,255,.55), rgba(255,255,255,.08));
        border-radius: 14px 14px 0 0;
    }
    .spine-node:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 40px rgba(30,64,175,.5), 0 4px 12px rgba(30,64,175,.25);
    }
    .spine-node strong {
        display: block;
        font-size: 14.5px; font-weight: 900; line-height: 1.45;
        letter-spacing: .01em;
        margin-bottom: 7px;
        padding-bottom: 7px;
        border-bottom: 1px solid rgba(255,255,255,.2);
    }
    .spine-node span {
        display: block;
        font-size: 11.5px; font-weight: 600; line-height: 1.5;
        opacity: .82; letter-spacing: .02em;
        font-style: italic;
    }
    /* Photo / initials avatar — inside card, right side */
    .spine-node-avatar {
        position: static; transform: none;
        width: 120px; height: 120px; border-radius: 14px;
        overflow: hidden; flex-shrink: 0;
        border: 3px solid rgba(255,255,255,.85);
        box-shadow: 0 4px 16px rgba(0,0,0,.3);
        background: #fff;
    }
    .spine-node-photo {
        width: 100%; height: 100%;
        object-fit: cover; object-position: center top; display: block;
        cursor: zoom-in;
    }
    /* Lightbox */
    .spine-lightbox {
        display: none;
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,0,0,.75);
        align-items: center; justify-content: center;
        backdrop-filter: blur(4px);
        cursor: zoom-out;
    }
    .spine-lightbox.active { display: flex; }
    .spine-lightbox-inner {
        display: flex; flex-direction: column; align-items: center;
        gap: 0;
        cursor: default;
    }
    .spine-lightbox img {
        max-width: min(420px, 88vw);
        max-height: 68vh;
        border-radius: 16px 16px 0 0;
        box-shadow: 0 24px 80px rgba(0,0,0,.6);
        object-fit: contain;
        display: block;
    }
    .spine-lightbox-caption {
        width: 100%;
        max-width: min(420px, 88vw);
        padding: 14px 20px 16px;
        border-radius: 0 0 16px 16px;
        background: rgba(15,30,80,.92);
        text-align: center;
    }
    .spine-lightbox-caption strong {
        display: block;
        color: #fff;
        font-size: 15px; font-weight: 900;
        line-height: 1.4; margin-bottom: 4px;
    }
    .spine-lightbox-caption span {
        display: block;
        color: rgba(255,255,255,.7);
        font-size: 12.5px; font-style: italic;
        line-height: 1.4;
    }
    .spine-node-initials {
        width: 100%; height: 100%;
        display: grid; place-items: center;
        background: linear-gradient(145deg, #1e3faf 0%, #2563eb 100%);
        color: #fff; font-size: 26px; font-weight: 900; line-height: 1;
    }
    /* "Behind" node — visually recessed, slightly different shade */
    .spine-row-behind .spine-node {
        background: linear-gradient(145deg, #1e3a8a 0%, #1d4ed8 100%);
        box-shadow: 0 6px 20px rgba(30,64,175,.3), inset 0 1px 0 rgba(255,255,255,.12);
    }
    /* Prominent node (second center / Kepala Balai) — slightly larger + gold accent */
    .spine-row-prominent .spine-node {
        min-width: 310px;
        border: 2px solid rgba(255,255,255,.32);
        box-shadow: 0 14px 40px rgba(30,64,175,.5), 0 4px 14px rgba(30,64,175,.25), inset 0 1px 0 rgba(255,255,255,.22);
    }
    .spine-row-prominent .spine-node::before {
        height: 4px;
        background: linear-gradient(90deg, #fbbf24, #f6c34a, rgba(246,195,74,.15));
    }
    /* Continuous spine line — slightly thicker */
    .spine-outer::before { width: 3px; background: #3b82f6; }
    /* Horizontal connectors */
    /* Branch nodes fill their half; hlines have fixed width */
    .spine-half .spine-node { flex: 1; min-width: 0; }
    .spine-hline { flex: 0 0 72px; min-width: 72px; }
    .spine-hline-solid    { height: 3px; background: #3b82f6; }
    .spine-hline-dashed   { height: 3px; background: repeating-linear-gradient(to right, #3b82f6 0 10px, transparent 10px 16px); }
    .spine-hline-dash-dot { height: 3px; background: repeating-linear-gradient(to right, #3b82f6 0 10px, transparent 10px 13px, #3b82f6 13px 15px, transparent 15px 20px); }
    /* Legend */
    .spine-legend {
        margin-top: 24px; padding: 16px 22px;
        border: 1.5px solid rgba(59,130,246,.15);
        border-left: 4px solid #f6c34a;
        border-radius: 14px;
        background: linear-gradient(135deg, #f8fbff, #f0f5ff);
        box-shadow: 0 4px 18px rgba(0,31,84,.06);
        display: grid; gap: 12px;
    }
    .spine-legend > strong {
        display: flex; align-items: center; gap: 8px;
        color: #0a1f44; font-size: 12px; font-weight: 900; letter-spacing: .06em; text-transform: uppercase;
    }
    .spine-legend-item { display: flex; align-items: center; gap: 14px; color: #344054; font-size: 12.5px; font-weight: 700; }
    .spine-legend-line { flex: 0 0 52px !important; min-width: 52px !important; }

    /* ===== Lokasi dan Kontak ===== */
    .kontak-wrap {
        position: relative;
        z-index: 1;
        display: grid;
        gap: 24px;
    }
    .kontak-top-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 420px;
        gap: 24px;
        align-items: start;
    }
    .kontak-info-stack {
        display: grid;
        gap: 12px;
        align-content: start;
    }
    .kontak-2col {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }
    .kontak-card {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 18px 22px;
        border-radius: 18px;
        background: #fff;
        border: 1.5px solid rgba(210, 228, 252, .8);
        box-shadow: 0 2px 8px rgba(0,31,84,.04), 0 6px 24px rgba(0,71,204,.07);
        transition: transform .22s ease, box-shadow .22s ease;
        position: relative;
        overflow: hidden;
    }
    .kontak-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 5px;
        background: linear-gradient(180deg, #0047cc 0%, #16a3e8 100%);
        border-radius: 5px 0 0 5px;
    }
    .kontak-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 32px rgba(0,71,204,.15), 0 2px 8px rgba(0,31,84,.07);
    }
    .kontak-card.card-email::before { background: linear-gradient(180deg, #0f766e 0%, #16a3e8 100%); }
    .kontak-card.card-email { border-color: rgba(167,243,208,.6); }
    .kontak-card.card-email:hover { box-shadow: 0 8px 32px rgba(15,118,110,.15), 0 2px 8px rgba(0,31,84,.06); }
    .kontak-card.card-wa::before { background: linear-gradient(180deg, #16a34a 0%, #22c55e 100%); }
    .kontak-card.card-wa { border-color: rgba(187,247,208,.6); }
    .kontak-card.card-wa:hover { box-shadow: 0 8px 32px rgba(22,163,74,.15), 0 2px 8px rgba(0,31,84,.06); }
    .kontak-card.card-hours::before { background: linear-gradient(180deg, #7c3aed 0%, #a78bfa 100%); }
    .kontak-card.card-hours { border-color: rgba(196,181,253,.5); }
    .kontak-card.card-hours:hover { box-shadow: 0 8px 32px rgba(124,58,237,.15), 0 2px 8px rgba(0,31,84,.06); }
    .kontak-card-icon {
        width: 52px;
        height: 52px;
        min-width: 52px;
        display: grid;
        place-items: center;
        border-radius: 14px;
        background: linear-gradient(145deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: 19px;
        box-shadow: 0 6px 20px rgba(0,71,204,.3), 0 2px 6px rgba(0,71,204,.12);
    }
    .kontak-card-body {
        min-width: 0;
        flex: 1;
    }
    .kontak-card-label {
        display: block;
        margin-bottom: 3px;
        color: #94a3b8;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .15em;
        text-transform: uppercase;
    }
    .kontak-card-value {
        display: block;
        color: #0a1f44;
        font-size: .97rem;
        font-weight: 700;
        line-height: 1.5;
        word-break: break-word;
    }
    .kontak-card-value a {
        color: inherit;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .kontak-card-value a:hover {
        color: #0047cc;
    }
    .kontak-card-arrow {
        margin-left: auto;
        color: #c8d7f4;
        font-size: 13px;
        transition: color .2s, transform .2s;
    }
    .kontak-card:hover .kontak-card-arrow {
        color: #0047cc;
        transform: translateX(3px);
    }
    .kontak-map-section {
        display: flex;
        flex-direction: column;
        border-radius: 20px;
        overflow: hidden;
        border: 1.5px solid rgba(210,228,252,.8);
        box-shadow: 0 8px 32px rgba(0,31,84,.1), 0 2px 8px rgba(0,31,84,.05);
        height: 100%;
    }
    .kontak-map-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 16px 22px;
        background: linear-gradient(130deg, #002fa7 0%, #0047cc 55%, #1a6af5 100%);
        color: #fff;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }
    .kontak-map-header::before {
        content: '';
        position: absolute;
        right: -30px; top: -30px;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
        pointer-events: none;
    }
    .kontak-map-header::after {
        content: '';
        position: absolute;
        right: 60px; bottom: -40px;
        width: 80px; height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
        pointer-events: none;
    }
    .kontak-map-header-live {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .1em;
        color: rgba(255,255,255,.9);
        position: relative;
        z-index: 1;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 20px;
        padding: 3px 10px;
    }
    .kontak-map-header-live::before {
        content: '';
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #4ade80;
        box-shadow: 0 0 0 2px rgba(74,222,128,.35);
        animation: kontak-pulse 2s infinite;
    }
    @keyframes kontak-pulse {
        0%, 100% { box-shadow: 0 0 0 2px rgba(74,222,128,.35); }
        50%       { box-shadow: 0 0 0 5px rgba(74,222,128,.1); }
    }
    .kontak-map-wrap {
        position: relative;
        overflow: hidden;
        flex: 1;
        min-height: 280px;
        background: #eef4ff;
    }
    .kontak-map-wrap iframe {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
        position: absolute;
        inset: 0;
    }
    .kontak-map-placeholder {
        display: grid;
        place-items: center;
        width: 100%; height: 100%;
        gap: 12px;
        color: #8290a3;
        font-size: .9rem;
        font-weight: 800;
        text-align: center;
        padding: 24px;
    }
    .kontak-cta-strip {
        border-radius: 18px;
        overflow: hidden;
        background: linear-gradient(130deg, #002fa7 0%, #0047cc 50%, #1a6af5 100%);
        box-shadow: 0 10px 36px rgba(0,71,204,.3), 0 2px 8px rgba(0,71,204,.12);
        position: relative;
    }
    .kontak-cta-strip::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
        pointer-events: none;
    }
    .kontak-cta-strip::after {
        content: '';
        position: absolute;
        bottom: -70px; left: 25%;
        width: 260px; height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,.04);
        pointer-events: none;
    }
    .kontak-cta-strip-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 24px 32px;
        position: relative;
        z-index: 1;
    }
    .kontak-cta-strip-icon {
        display: grid;
        place-items: center;
        width: 50px; height: 50px;
        border-radius: 14px;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.25);
        color: #fff;
        font-size: 22px;
        flex-shrink: 0;
    }
    .kontak-cta-strip-copy strong {
        display: block;
        color: #fff;
        font-size: 1.05rem;
        font-weight: 900;
        margin-bottom: 4px;
    }
    .kontak-cta-strip-copy span {
        display: block;
        color: rgba(255,255,255,.72);
        font-size: .87rem;
    }
    .kontak-cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        min-height: 46px;
        padding: 12px 26px;
        border-radius: 12px;
        background: rgba(255,255,255,.18);
        border: 1.5px solid rgba(255,255,255,.4);
        color: #fff;
        font-size: 14px;
        font-weight: 900;
        text-decoration: none;
        white-space: nowrap;
        transition: background .2s, transform .2s, box-shadow .2s;
        backdrop-filter: blur(6px);
    }
    .kontak-cta:hover {
        background: rgba(255,255,255,.28);
        transform: translateY(-2px);
        color: #fff;
        text-decoration: none;
        box-shadow: 0 8px 24px rgba(0,0,0,.2);
    }
    @media (max-width: 900px) {
        .kontak-top-grid { grid-template-columns: 1fr; }
        .kontak-map-section { order: -1; min-height: 320px; }
        .kontak-cta-strip-inner { flex-direction: column; align-items: flex-start; }
        .kontak-cta-strip-icon { display: none; }
    }
    @media (max-width: 600px) {
        .kontak-2col { grid-template-columns: 1fr; }
        .kontak-cta-strip-inner { padding: 20px 22px; }
        .kontak-cta { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')
@include('pages.partials.menu_detail_hero', ['menuGroup' => $menuGroup, 'pageTitle' => $pageTitle])

@php
    $profileMenu = collect();
    if (($menuGroup ?? '') === 'Profil') {
        $storedProfilePages = \App\Models\ProfilePage::query()
            ->where('slug', '!=', 'informasi-pejabat')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();
        $profileMenu = $storedProfilePages->isNotEmpty()
            ? $storedProfilePages->map(fn ($page) => [
                'label' => $page->title,
                'url' => $page->publicUrl(),
                'slug' => $page->slug,
            ])
            : collect(\App\Models\ProfilePage::defaultMenu())->map(fn ($item) => [
                'label' => $item['title'],
                'url' => route($item['route']),
                'slug' => $item['slug'],
            ]);
    }
    $profileContent = $profilePage?->content ?? null;
    $orgChartData = null;
    $isSpineLayout = false;
    if (($profilePage?->slug ?? null) === 'struktur-organisasi' && $profileContent) {
        $decoded = json_decode($profileContent, true);
        if (is_array($decoded) && !empty($decoded)) {
            $orgChartData = $decoded;
            $isSpineLayout = isset($decoded[0]['side']);
        }
    }
    $renderProfileContent = function (?string $content): string {
        $lines = preg_split('/\R/', trim((string) $content));
        $html = '';
        $paragraph = [];
        $list = [];
        $orderedList = [];

        $flushParagraph = function () use (&$html, &$paragraph): void {
            if ($paragraph === []) return;
            $html .= '<p>' . e(implode(' ', $paragraph)) . '</p>';
            $paragraph = [];
        };
        $flushList = function () use (&$html, &$list): void {
            if ($list === []) return;
            $html .= '<ul>';
            foreach ($list as $item) {
                $html .= '<li>' . e($item) . '</li>';
            }
            $html .= '</ul>';
            $list = [];
        };
        $flushOrderedList = function () use (&$html, &$orderedList): void {
            if ($orderedList === []) return;
            $html .= '<ol>';
            foreach ($orderedList as $item) {
                $html .= '<li>' . e($item) . '</li>';
            }
            $html .= '</ol>';
            $orderedList = [];
        };
        $flushAll = function () use ($flushParagraph, $flushList, $flushOrderedList): void {
            $flushParagraph();
            $flushList();
            $flushOrderedList();
        };

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                $flushAll();
                continue;
            }
            if (str_starts_with($line, '## ')) {
                $flushAll();
                $html .= '<h3>' . e(trim(substr($line, 3))) . '</h3>';
                continue;
            }
            if (preg_match('/^[A-Za-zÀ-ÿ ]+:$/', $line)) {
                $flushAll();
                $html .= '<h3 class="profile-section-title">' . e(rtrim($line, ':')) . '</h3>';
                continue;
            }
            if (str_starts_with($line, '- ')) {
                $flushParagraph();
                $flushOrderedList();
                $list[] = trim(substr($line, 2));
                continue;
            }
            if (preg_match('/^(?:\d+|[a-zA-Z])[\.\)]\s+(.+)$/', $line, $matches)) {
                $flushParagraph();
                $flushList();
                $orderedList[] = trim($matches[1]);
                continue;
            }
            $flushList();
            $flushOrderedList();
            $paragraph[] = $line;
        }

        $flushAll();

        return $html;
    };
@endphp

<section class="menu-detail-section">
    <div class="container">
        <nav class="page-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            @if (isset($menuGroup) && $menuGroup !== $pageTitle)
                <span>{{ $menuGroup }}</span>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            @endif
            <span class="bc-current">{{ $pageTitle }}</span>
        </nav>
        @if (($menuGroup ?? '') === 'Profil')
            <div class="menu-detail-layout">
                @php $profileSlug = $profilePage?->slug ?? null; @endphp
                <main>
                    @if ($orgChartData !== null)
                        <div class="profile-content-card">
                            <div class="profile-content-heading">
                                <p class="profile-content-kicker">Profil Balai Air Tanah</p>
                                <h2 class="profile-content-title">{{ $pageTitle }}</h2>
                            </div>
                            <div class="org-wrap">
                                @if ($isSpineLayout)
                                    @include('pages.partials.org_spine', ['orgChartData' => $orgChartData])
                                @else
                                    @php
                                        $orgRoots = array_values(array_filter($orgChartData, fn($n) => empty($n['parent']) && empty($n['standalone'])));
                                        $orgSolo  = array_values(array_filter($orgChartData, fn($n) => !empty($n['standalone'])));
                                    @endphp
                                    @if (!empty($orgRoots))
                                        <ul class="org-tree">
                                            @foreach ($orgRoots as $orgRoot)
                                                @include('pages.partials.org_node', ['node' => $orgRoot, 'allNodes' => $orgChartData])
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="org-empty-state">Struktur organisasi belum tersedia.</div>
                                    @endif
                                    @if (!empty($orgSolo))
                                        <div class="org-standalone-section">
                                            @foreach ($orgSolo as $sn)
                                                <div class="org-standalone-pill" style="background: {{ $sn['color'] ?? '#6b7280' }}">
                                                    {{ $sn['position'] ?? '' }}
                                                    @if (!empty($sn['name']))<br><small style="font-weight:700;font-size:11px;opacity:.85;">{{ $sn['name'] }}</small>@endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @elseif ($profileSlug === 'lokasi-dan-kontak')
                        @php
                            $kontakData = [];
                            if ($profileContent) {
                                $decoded = json_decode($profileContent, true);
                                if (is_array($decoded)) $kontakData = $decoded;
                            }
                            $kAddress   = $kontakData['address']   ?? '';
                            $kPhone     = $kontakData['phone']      ?? '';
                            $kFax       = $kontakData['fax']        ?? '';
                            $kEmail     = $kontakData['email']      ?? '';
                            $kHours     = $kontakData['hours']      ?? '';
                            $kWhatsapp  = $kontakData['whatsapp']   ?? '';
                            $kMapsUrl   = $kontakData['maps_url']   ?? '';
                            $kMapsEmbed = $kontakData['maps_embed'] ?? '';
                        @endphp
                        <div class="profile-content-card">
                            <div class="profile-content-heading">
                                <p class="profile-content-kicker">Profil Balai Air Tanah</p>
                                <h2 class="profile-content-title">{{ $pageTitle }}</h2>
                            </div>
                            <div class="kontak-wrap">
                                <div class="kontak-top-grid">
                                    <div class="kontak-info-stack">
                                        @if ($kAddress)
                                            <div class="kontak-card">
                                                <div class="kontak-card-icon"><i class="fa-solid fa-location-dot"></i></div>
                                                <div class="kontak-card-body">
                                                    <span class="kontak-card-label">Alamat</span>
                                                    <span class="kontak-card-value">{{ $kAddress }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($kPhone || $kWhatsapp)
                                            <div class="kontak-2col">
                                                @if ($kPhone)
                                                    <div class="kontak-card">
                                                        <div class="kontak-card-icon"><i class="fa-solid fa-phone"></i></div>
                                                        <div class="kontak-card-body">
                                                            <span class="kontak-card-label">Telepon</span>
                                                            <span class="kontak-card-value">
                                                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $kPhone) }}">{{ $kPhone }}</a>
                                                            </span>
                                                        </div>
                                                        <i class="fa-solid fa-chevron-right kontak-card-arrow"></i>
                                                    </div>
                                                @endif
                                                @if ($kWhatsapp)
                                                    <div class="kontak-card card-wa">
                                                        <div class="kontak-card-icon" style="background:linear-gradient(145deg,#16a34a,#22c55e);box-shadow:0 6px 20px rgba(22,163,74,.3)"><i class="fa-brands fa-whatsapp"></i></div>
                                                        <div class="kontak-card-body">
                                                            <span class="kontak-card-label">WhatsApp</span>
                                                            <span class="kontak-card-value">
                                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kWhatsapp) }}" target="_blank" rel="noopener">{{ $kWhatsapp }}</a>
                                                            </span>
                                                        </div>
                                                        <i class="fa-solid fa-chevron-right kontak-card-arrow"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        @if ($kEmail)
                                            <div class="kontak-card card-email">
                                                <div class="kontak-card-icon" style="background:linear-gradient(145deg,#0f766e,#16a3e8);box-shadow:0 6px 20px rgba(15,118,110,.28)"><i class="fa-solid fa-envelope"></i></div>
                                                <div class="kontak-card-body">
                                                    <span class="kontak-card-label">Email</span>
                                                    <span class="kontak-card-value">
                                                        <a href="mailto:{{ $kEmail }}">{{ $kEmail }}</a>
                                                    </span>
                                                </div>
                                                <i class="fa-solid fa-chevron-right kontak-card-arrow"></i>
                                            </div>
                                        @endif
                                        @if ($kHours)
                                            <div class="kontak-card card-hours">
                                                <div class="kontak-card-icon" style="background:linear-gradient(145deg,#7c3aed,#a78bfa);box-shadow:0 6px 20px rgba(124,58,237,.28)"><i class="fa-solid fa-clock"></i></div>
                                                <div class="kontak-card-body">
                                                    <span class="kontak-card-label">Jam Operasional</span>
                                                    <span class="kontak-card-value">{{ $kHours }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!$kAddress && !$kPhone && !$kFax && !$kEmail && !$kWhatsapp && !$kHours)
                                            <div class="profile-content-empty">Informasi kontak belum tersedia.</div>
                                        @endif
                                    </div>
                                    <div class="kontak-map-section">
                                        <div class="kontak-map-header">
                                            <i class="fa-solid fa-map-location-dot"></i>
                                            Lokasi Kami
                                            <span class="kontak-map-header-live">LIVE</span>
                                        </div>
                                        <div class="kontak-map-wrap">
                                            @if ($kMapsEmbed)
                                                <iframe src="{{ $kMapsEmbed }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            @else
                                                <div class="kontak-map-placeholder">
                                                    <i class="fa-solid fa-map-location-dot" style="font-size:2.5rem;color:#c8d7f4;"></i>
                                                    Peta belum dikonfigurasi.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if ($kMapsUrl)
                                    <div class="kontak-cta-strip">
                                        <div class="kontak-cta-strip-inner">
                                            <div class="kontak-cta-strip-copy">
                                                <strong>Temukan kami di Google Maps</strong>
                                                <span>Navigasi langsung ke lokasi Balai Air Tanah</span>
                                            </div>
                                            <a href="{{ $kMapsUrl }}" target="_blank" rel="noopener" class="kontak-cta">
                                                <i class="fa-solid fa-map-location-dot"></i>
                                                Buka di Google Maps
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        @include('pages.partials.profile_content_card', [
                            'title' => $pageTitle,
                            'content' => $profileContent,
                            'emptyText' => 'Konten ' . strtolower($pageTitle) . ' akan ditampilkan di halaman ini.',
                        ])
                    @endif
                    @if (($profilePage?->slug ?? null) === 'tentang-kami')
                        <div class="profile-info-strip" aria-label="Ringkasan profil">
                            <div class="profile-info-item" data-index="01">
                                <span class="profile-info-icon"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                                <strong>Layanan Teknis</strong>
                                <span>Dukungan pengelolaan dan pengembangan air tanah.</span>
                            </div>
                            <div class="profile-info-item" data-index="02">
                                <span class="profile-info-icon"><i class="fa-solid fa-database"></i></span>
                                <strong>Data & Informasi</strong>
                                <span>Penguatan informasi untuk keputusan berbasis data.</span>
                            </div>
                            <div class="profile-info-item" data-index="03">
                                <span class="profile-info-icon"><i class="fa-solid fa-flask"></i></span>
                                <strong>Laboratorium</strong>
                                <span>Dukungan pengujian dan penerapan teknologi.</span>
                            </div>
                        </div>
                    @endif
                </main>
                <aside class="profile-sidebar" aria-label="Menu profil">
                    <div class="profile-sidebar-header">
                        <span class="profile-sidebar-title">Profil</span>
                    </div>
                    @php
                        $profileMenuIcons = [
                            'tentang-kami'        => 'fa-solid fa-circle-info',
                            'tugas-dan-fungsi'    => 'fa-solid fa-list-check',
                            'visi-dan-misi'       => 'fa-solid fa-bullseye',
                            'struktur-organisasi' => 'fa-solid fa-sitemap',
                            'zona-integritas'     => 'fa-solid fa-shield-halved',
                            'lokasi-dan-kontak'   => 'fa-solid fa-location-dot',
                        ];
                    @endphp
                    <ul class="profile-menu">
                        @foreach ($profileMenu as $item)
                            <li>
                                <a href="{{ $item['url'] }}"
                                   class="profile-menu-link {{ ($profilePage?->slug ?? null) === $item['slug'] ? 'is-active' : '' }}">
                                    <span class="profile-menu-icon">
                                        <i class="{{ $profileMenuIcons[$item['slug']] ?? 'fa-solid fa-file' }}"></i>
                                    </span>
                                    <span class="profile-menu-text">{{ $item['label'] }}</span>
                                    <i class="fa-solid fa-chevron-right profile-menu-arrow"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </aside>
            </div>
        @else
            <main class="menu-detail-main">
                <h2>{{ $pageTitle }}</h2>
                <p>Konten {{ strtolower($pageTitle) }} akan ditampilkan di halaman ini.</p>
            </main>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<!-- Lightbox overlay -->
<div class="spine-lightbox" id="spineLightbox">
    <div class="spine-lightbox-inner">
        <img id="spineLightboxImg" src="" alt="">
        <div class="spine-lightbox-caption" id="spineLightboxCaption">
            <strong id="spineLightboxName"></strong>
            <span id="spineLightboxPos"></span>
        </div>
    </div>
</div>

<script>
(function () {
    /* Lightbox */
    var lb   = document.getElementById('spineLightbox');
    var img  = document.getElementById('spineLightboxImg');
    var lbName = document.getElementById('spineLightboxName');
    var lbPos  = document.getElementById('spineLightboxPos');
    function closeLb() { lb.classList.remove('active'); img.src = ''; }
    document.addEventListener('click', function (e) {
        var photo = e.target.closest('.spine-node-photo');
        if (photo) {
            img.src = photo.src;
            lbName.textContent = photo.dataset.name || '';
            lbPos.textContent  = photo.dataset.position || '';
            lb.classList.add('active');
            return;
        }
        if (e.target === lb) closeLb();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeLb();
    });
})();

(function () {
    var outer = document.querySelector('.spine-outer');
    if (!outer) return;
    var ctrNodes = outer.querySelectorAll('.center-row .spine-node');
    if (ctrNodes.length < 1) return;
    var first = ctrNodes[0];
    var last  = ctrNodes[ctrNodes.length - 1];
    var outerRect = outer.getBoundingClientRect();
    var firstRect = first.getBoundingClientRect();
    var lastRect  = last.getBoundingClientRect();
    var topPx    = (firstRect.top  - outerRect.top  + firstRect.height / 2);
    var bottomPx = (outerRect.bottom - lastRect.bottom + lastRect.height / 2);
    outer.style.setProperty('--spine-top',    topPx    + 'px');
    outer.style.setProperty('--spine-bottom', bottomPx + 'px');
})();
</script>
@endpush
