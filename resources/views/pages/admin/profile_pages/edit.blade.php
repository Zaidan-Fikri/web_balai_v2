@extends('master.admin.app')

@section('title', 'Edit ' . $profilePage->title)

@push('styles')
@include('pages.partials.profile_content_styles')
<style>
    .profile-edit-shell {
        display: grid;
        grid-template-columns: minmax(0, 1.45fr) minmax(300px, .8fr);
        gap: 22px;
        align-items: start;
    }
    .profile-editor-card,
    .profile-preview-card {
        border: 1px solid rgba(0, 51, 153, .12);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 18px 48px rgba(0, 31, 84, .07);
    }
    .profile-editor-card {
        padding: 22px;
    }
    .profile-editor {
        display: grid;
        gap: 18px;
    }
    .profile-form-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 140px;
        gap: 14px;
    }
    .profile-field {
        display: grid;
        gap: 8px;
    }
    .profile-field.full {
        grid-column: 1 / -1;
    }
    .profile-field label,
    .profile-editor-label {
        color: #0a1f44;
        font-size: 13px;
        font-weight: 900;
    }
    .profile-field-hint {
        margin: -2px 0 0;
        color: #8290a3;
        font-size: 12px;
        line-height: 1.5;
    }
    .profile-editor .popup-textarea {
        min-height: 380px;
        background: #fff;
        font-weight: 500;
        line-height: 1.75;
        resize: vertical;
    }
    .profile-editor-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding-top: 2px;
    }
    .profile-admin-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 11px 18px;
        border: 1px solid rgba(0, 51, 153, .22);
        border-radius: 14px;
        background: #fff;
        color: var(--navy-dark);
        font-size: 14px;
        font-weight: 900;
        cursor: pointer;
        text-decoration: none;
    }
    .profile-preview-card {
        position: sticky;
        top: 96px;
        overflow: hidden;
        padding: 22px;
        background:
            linear-gradient(180deg, #ffffff 0%, #f7faff 100%);
    }
    .profile-preview-surface {
        position: relative;
        overflow: hidden;
        padding: 30px 30px 26px;
        border: 1px solid rgba(0, 51, 153, .08);
        border-radius: 16px;
        background:
            linear-gradient(135deg, rgba(255,255,255,.98), rgba(247,250,255,.98)),
            #fff;
        box-shadow: 0 18px 46px rgba(0, 31, 84, .08);
    }
    .profile-preview-surface::after {
        content: "BAT";
        position: absolute;
        top: 24px;
        right: 22px;
        color: rgba(0, 51, 153, .035);
        font-size: 4.8rem;
        font-weight: 900;
        line-height: 1;
        pointer-events: none;
    }
    .profile-preview-surface::before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: 5px;
        background: linear-gradient(90deg, #0047cc, #16a3e8, #f6c34a);
    }
    .profile-preview-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 10px;
        color: #0047cc;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }
    .profile-preview-kicker::before {
        content: "";
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: #f6c34a;
    }
    .profile-preview-heading-row {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 22px;
    }
    .profile-preview-heading-copy .profile-preview-title {
        margin-bottom: 0;
    }
    .profile-preview-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 30px;
        padding: 7px 10px;
        border: 1px solid #dce7fb;
        border-radius: 999px;
        background: #fff;
        color: #0047cc;
        font-size: 10px;
        font-weight: 900;
        white-space: nowrap;
        box-shadow: 0 8px 20px rgba(0, 31, 84, .06);
    }
    .profile-preview-badge i {
        color: #f6c34a;
    }
    .profile-preview-title {
        margin: 0 0 16px;
        color: #0a1f44;
        font-size: 1.78rem;
        font-weight: 900;
        line-height: 1.25;
    }
    .profile-preview-body {
        position: relative;
        z-index: 1;
        min-height: 190px;
        padding-left: 18px;
        border-left: 3px solid #e8eefb;
        color: #475467;
        font-size: 13.5px;
        line-height: 1.9;
    }
    .profile-preview-intro-grid {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 16px;
    }
    .profile-preview-highlight {
        position: relative;
        padding: 16px;
        border: 1px solid #dfe9fb;
        border-radius: 14px;
        background: linear-gradient(180deg, #ffffff 0%, #f7faff 100%);
        box-shadow: 0 12px 26px rgba(0, 31, 84, .07);
    }
    .profile-preview-highlight::before {
        content: "";
        position: absolute;
        top: 14px;
        left: 16px;
        width: 32px;
        height: 3px;
        border-radius: 999px;
        background: #f6c34a;
    }
    .profile-preview-highlight-icon {
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        margin: 12px 0 9px;
        border-radius: 12px;
        background: #0047cc;
        color: #fff;
        box-shadow: 0 10px 20px rgba(0, 71, 204, .16);
    }
    .profile-preview-highlight h5 {
        margin: 0 0 8px;
        padding: 0;
        background: none;
        color: #0a1f44;
        font-size: .95rem;
    }
    .profile-preview-highlight h5::before {
        content: none;
    }
    .profile-preview-highlight p {
        margin: 0 0 12px;
        color: #667085;
        font-size: 12px;
        line-height: 1.65;
    }
    .profile-preview-highlight-list {
        display: grid;
        gap: 8px;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .profile-preview-highlight-list li {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0;
        border: 0;
        background: transparent;
        color: #0a1f44;
        font-size: 12px;
        font-weight: 800;
    }
    .profile-preview-highlight-list li::before {
        content: none;
    }
    .profile-preview-highlight-list i {
        width: 23px;
        height: 23px;
        display: grid;
        place-items: center;
        border-radius: 8px;
        background: #eef4ff;
        color: #0047cc;
        font-size: 10px;
    }
    .profile-preview-body p {
        margin: 0 0 15px;
    }
    .profile-preview-body p:last-child {
        margin-bottom: 0;
    }
    .profile-preview-body h5 {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 24px 0 10px;
        padding: 0 0 0 2px;
        color: #0a1f44;
        font-size: .86rem;
        font-weight: 900;
    }
    .profile-preview-body h5::before {
        content: "";
        width: 18px;
        height: 2px;
        border-radius: 999px;
        background: #f6c34a;
    }
    .profile-preview-body ul,
    .profile-preview-body ol {
        display: grid;
        gap: 8px;
        margin: 10px 0 18px;
        padding: 0;
        list-style: none;
    }
    .profile-preview-body ol {
        counter-reset: profile-preview-list;
    }
    .profile-preview-body li {
        position: relative;
        min-height: 34px;
        padding: 7px 0 7px 34px;
        color: #475467;
        line-height: 1.75;
    }
    .profile-preview-body li::before {
        content: "";
        position: absolute;
        top: 14px;
        left: 9px;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #f6c34a;
        box-shadow: 0 0 0 4px #fff6dc;
    }
    .profile-preview-body ol li {
        counter-increment: profile-preview-list;
    }
    .profile-preview-body ol li::before {
        content: counter(profile-preview-list);
        top: 8px;
        left: 0;
        width: 24px;
        height: 24px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: #eef4ff;
        box-shadow: none;
        color: #0047cc;
        font-size: 10px;
        font-weight: 900;
    }
    .profile-preview-empty {
        display: grid;
        place-items: center;
        min-height: 220px;
        padding: 22px;
        border: 1.5px dashed #c8d7f4;
        border-radius: 14px;
        background: #f7faff;
        color: #8290a3;
        text-align: center;
        font-weight: 800;
    }
    .profile-writing-tips {
        position: relative;
        z-index: 1;
        display: grid;
        gap: 8px;
        margin-top: 22px;
        padding: 15px 16px;
        border: 1px solid #e1eafe;
        border-radius: 14px;
        background:
            linear-gradient(180deg, #ffffff 0%, #f7faff 100%);
    }
    .profile-writing-tips strong {
        color: #0a1f44;
        font-size: 13px;
    }
    .profile-writing-tips span {
        display: block;
        color: #667085;
        font-size: 12px;
        line-height: 1.55;
    }
    .profile-preview-strip {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid #e6edf8;
    }
    .profile-preview-info {
        position: relative;
        overflow: hidden;
        padding: 13px;
        border: 1px solid #e1eafe;
        border-radius: 12px;
        background: linear-gradient(180deg, #ffffff 0%, #f7faff 100%);
    }
    .profile-preview-info::before {
        content: attr(data-index);
        position: absolute;
        top: 8px;
        right: 10px;
        color: rgba(0, 71, 204, .12);
        font-size: 1.15rem;
        font-weight: 900;
        line-height: 1;
    }
    .profile-preview-info-icon {
        width: 28px;
        height: 28px;
        display: grid;
        place-items: center;
        margin-bottom: 8px;
        border-radius: 10px;
        background: #0047cc;
        color: #fff;
        font-size: 11px;
        box-shadow: 0 8px 18px rgba(0, 71, 204, .16);
    }
    .profile-preview-info strong {
        display: block;
        margin-bottom: 4px;
        color: #0a1f44;
        font-size: 12px;
        font-weight: 900;
    }
    .profile-preview-info span {
        display: block;
        color: #667085;
        font-size: 11px;
        line-height: 1.5;
    }
    @media (max-width: 1100px) {
        .profile-edit-shell {
            grid-template-columns: 1fr;
        }
        .profile-preview-card {
            position: static;
        }
    }
    @media (max-width: 640px) {
        .profile-editor-card {
            padding: 16px;
        }
        .profile-form-grid {
            grid-template-columns: 1fr;
        }
    }
    /* ===== Org Chart Editor ===== */
    .org-editor-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }
    .org-btn-add {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 36px;
        padding: 8px 14px;
        border: 1.5px dashed #0047cc;
        border-radius: 10px;
        background: #f0f6ff;
        color: #0047cc;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        transition: background .15s;
    }
    .org-btn-add:hover { background: #e4efff; }
    .org-list { display: grid; gap: 8px; }
    .org-row {
        display: grid;
        grid-template-columns: minmax(0,1fr) minmax(0,1fr) 164px 164px 36px;
        gap: 8px;
        align-items: center;
        padding: 10px 12px;
        border: 1px solid #e1eafe;
        border-radius: 12px;
        background: #fafcff;
    }
    .org-input, .org-select {
        height: 36px;
        padding: 0 10px;
        border: 1px solid #d0daf0;
        border-radius: 8px;
        background: #fff;
        color: #0a1f44;
        font-size: 13px;
        font-weight: 700;
        width: 100%;
        box-sizing: border-box;
    }
    .org-select { cursor: pointer; }
    .org-btn-del {
        width: 36px;
        height: 36px;
        display: grid;
        place-items: center;
        border: 1px solid #fecdca;
        border-radius: 8px;
        background: #fff5f5;
        color: #b42318;
        font-size: 16px;
        cursor: pointer;
        font-weight: 900;
        flex-shrink: 0;
        transition: background .15s;
    }
    .org-btn-del:hover { background: #fee4e2; }
    .org-editor-empty {
        display: grid;
        place-items: center;
        padding: 28px;
        border: 1.5px dashed #c8d7f4;
        border-radius: 14px;
        background: #f7faff;
        color: #8290a3;
        font-size: 13px;
        font-weight: 800;
        text-align: center;
    }
    @media (max-width: 860px) {
        .org-row {
            grid-template-columns: 1fr 1fr 36px;
            grid-template-rows: auto auto;
        }
        .org-row > .org-input:first-child { grid-column: 1; }
        .org-row > .org-input:nth-child(2) { grid-column: 2; }
        .org-row > .org-btn-del { grid-column: 3; grid-row: 1; }
        .org-row > .org-select:nth-child(3) { grid-column: 1; }
        .org-row > .org-select:nth-child(4) { grid-column: 2; }
    }
    /* ===== Org Chart (preview) ===== */
    .org-wrap {
        overflow-x: auto;
        padding: 32px 24px 28px;
        text-align: center;
        background: radial-gradient(ellipse 80% 60% at 50% 10%, #dbeafe 0%, #eff6ff 45%, #f8faff 100%);
        border-radius: 14px;
        margin-top: 10px;
    }
    .org-tree, .org-children { list-style:none; margin:0; padding:0; }
    .org-tree { display: inline-flex; min-width: max-content; }
    .org-tree > .org-item > .org-vline:first-child { display: none; }
    .org-item { display: inline-flex; flex-direction: column; align-items: center; position: relative; padding: 0 12px; }
    .org-vline { width: 2px; height: 22px; background: #2563eb; flex-shrink: 0; }
    .org-children { display: inline-flex; flex-direction: row; align-items: flex-start; }
    .org-children > .org-item::before,
    .org-children > .org-item::after { content:''; position:absolute; top:0; height:2px; background:#2563eb; width:50%; }
    .org-children > .org-item::before { right:50%; }
    .org-children > .org-item::after  { left:50%; }
    .org-children > .org-item:first-child::before,
    .org-children > .org-item:only-child::before { display:none; }
    .org-children > .org-item:last-child::after,
    .org-children > .org-item:only-child::after  { display:none; }
    .org-node-wrap { display:flex; flex-direction:column; align-items:center; --nc:#0047cc; }
    .org-avatar {
        width: 54px; height: 54px; border-radius: 50%;
        background: var(--nc); display: grid; place-items: center;
        color: #fff; font-size: 19px; font-weight: 900;
        border: 3px solid #fff; box-shadow: 0 6px 20px rgba(0,0,0,.2);
        position: relative; z-index: 2; margin-bottom: -14px; flex-shrink: 0;
    }
    .org-card {
        position: relative; z-index: 1;
        min-width: 136px; max-width: 200px;
        padding: 20px 14px 11px;
        border: 2.5px solid var(--nc, #0047cc);
        border-radius: 10px; background: #fff; text-align: center;
        box-shadow: 0 8px 24px rgba(0,0,0,.09);
    }
    .org-name { display:block; color:#0a1f44; font-size:12px; font-weight:900; line-height:1.5; margin-bottom:8px; }
    .org-pos  {
        display:inline-block; padding:4px 10px; border-radius:5px;
        background:var(--nc,#0047cc); color:#fff; font-size:9.5px;
        font-weight:800; line-height:1.45; max-width:100%;
        word-break:break-word; white-space:normal;
    }
    .org-standalone-section {
        display:flex; justify-content:center; flex-wrap:wrap; gap:14px;
        margin-top:30px; padding-top:24px; border-top:2px dashed #c8d7f4;
    }
    .org-standalone-pill {
        padding:14px 34px; border-radius:999px; color:#fff;
        font-size:14px; font-weight:900; text-align:center;
        box-shadow:0 8px 24px rgba(0,0,0,.14);
        border: 2px solid rgba(255,255,255,.2);
    }
    .org-preview-empty {
        display:grid; place-items:center; min-height:130px;
        border:1.5px dashed #c8d7f4; border-radius:12px;
        background:#f7faff; color:#8290a3; font-size:12px;
        font-weight:800; text-align:center; padding:20px;
    }
    /* Admin editor extra fields */
    .org-row {
        display: grid;
        grid-template-columns: minmax(0,1fr) minmax(0,1fr) 36px;
        gap: 8px;
        align-items: start;
        padding: 10px 12px;
        border: 1px solid #e1eafe;
        border-radius: 12px;
        background: #fafcff;
    }
    .org-row-sub {
        grid-column: 1 / -1;
        display: grid;
        grid-template-columns: minmax(0,1fr) minmax(0,1fr) 44px auto;
        gap: 8px;
        align-items: center;
    }
    .org-row-sub.spine-sub {
        grid-template-columns: minmax(0,1fr) 68px minmax(0,1fr) 46px;
        align-items: center;
    }
    .org-photo-btn {
        width: 46px; height: 46px; border-radius: 50%;
        border: 2px dashed #c8d7f4; background: #f7faff;
        display: grid; place-items: center;
        cursor: pointer; overflow: hidden;
        color: #8290a3; font-size: 13px; flex-shrink: 0;
        transition: border-color .15s, background .15s;
        position: relative;
    }
    .org-photo-btn:hover { border-color: #0047cc; background: #eaf1ff; color: #0047cc; }
    .org-photo-btn.has-photo { border-style: solid; border-color: #3b82f6; }
    .org-photo-thumb { width: 100%; height: 100%; object-fit: cover; display: block; }
    .spine-node.has-avatar {
        display: flex; align-items: center; gap: 14px;
        text-align: left; padding: 16px 18px;
    }
    .spine-node-content { flex: 1; min-width: 0; }
    .spine-node-avatar {
        position: static; transform: none;
        width: 120px; height: 120px; border-radius: 14px;
        overflow: hidden; flex-shrink: 0;
        border: 3px solid rgba(255,255,255,.85);
        box-shadow: 0 4px 16px rgba(0,0,0,.3);
        background: #fff;
    }
    .spine-node-photo { width: 100%; height: 100%; object-fit: cover; object-position: center top; display: block; }
    .spine-node-initials {
        width: 100%; height: 100%; display: grid; place-items: center;
        background: linear-gradient(145deg, #1e3faf 0%, #2563eb 100%);
        color: #fff; font-size: 26px; font-weight: 900; line-height: 1;
    }
    .org-color-input {
        width: 44px; height: 36px; padding: 2px 3px;
        border: 1px solid #d0daf0; border-radius: 8px;
        cursor: pointer; background: #fff;
    }
    .org-standalone-label {
        display: flex; align-items: center; gap: 6px;
        color: #475467; font-size: 12px; font-weight: 700;
        cursor: pointer; white-space: nowrap;
    }
    .org-mode-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 10px; border-radius: 999px;
        font-size: 11px; font-weight: 900; letter-spacing: .04em;
        background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;
    }
    .org-mode-toggle {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 12px; border-radius: 10px; border: 1px solid #d0daf0;
        background: #fff; color: #475467; font-size: 12px; font-weight: 800;
        cursor: pointer; transition: background .15s;
    }
    .org-mode-toggle:hover { background: #f0f4ff; color: #0047cc; }
    /* Spine preview CSS */
    .spine-wrap { overflow-x: auto; padding: 12px 0; }
    .spine-outer {
        position: relative;
        min-width: 640px; max-width: 960px;
        margin: 0 auto;
    }
    .spine-outer::before {
        content: '';
        position: absolute;
        top: var(--spine-top, 0); bottom: var(--spine-bottom, 0);
        left: 50%; width: 3px; background: #3b82f6;
        transform: translateX(-50%); z-index: 0; pointer-events: none;
    }
    .spine-row { display: flex; align-items: center; position: relative; z-index: 1; }
    .spine-row.center-row { justify-content: center; padding: 8px 0; }
    .spine-row.branch-row { padding: 18px 0; }
    .spine-row-behind {
        position: relative;
        z-index: 1;
        margin-bottom: -38px;
    }
    .spine-row-behind .spine-ctr-cell { transform: translateX(-80px); }
    .spine-row-behind .spine-node {
        padding-top: 8px;
        padding-bottom: 30px;
    }
    .spine-row-behind + .spine-row.center-row {
        position: relative;
        z-index: 3;
    }
    .spine-row-behind + .spine-row.center-row .spine-ctr-cell { transform: translateX(50px); }
    .spine-spacer { flex: 1; }
    .spine-ctr-cell { display: flex; justify-content: center; }
    .spine-half { flex: 1; display: flex; align-items: center; }
    .spine-half.left  { flex-direction: row; }
    .spine-half.right { flex-direction: row; }
    .spine-half-empty { min-height: 76px; }
    .spine-node {
        position: relative; z-index: 1;
        min-width: 200px; max-width: none; padding: 14px 18px;
        background: linear-gradient(145deg, #1e3faf 0%, #2563eb 100%);
        color: #fff; border-radius: 14px;
        border: 1.5px solid rgba(255,255,255,.22);
        text-align: center;
        box-shadow:
            0 10px 32px rgba(30,64,175,.4),
            0 2px 8px rgba(30,64,175,.2),
            inset 0 1px 0 rgba(255,255,255,.18);
        word-break: break-word; flex-shrink: 0;
        overflow: visible;
        transition: transform .2s, box-shadow .2s;
    }
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
    .spine-row-behind .spine-node {
        background: linear-gradient(145deg, #1e3a8a 0%, #1d4ed8 100%);
        box-shadow: 0 6px 20px rgba(30,64,175,.3), inset 0 1px 0 rgba(255,255,255,.12);
    }
    .spine-row-prominent .spine-node {
        min-width: 310px;
        border: 2px solid rgba(255,255,255,.32);
        box-shadow: 0 14px 40px rgba(30,64,175,.5), 0 4px 14px rgba(30,64,175,.25), inset 0 1px 0 rgba(255,255,255,.22);
    }
    .spine-row-prominent .spine-node::before {
        height: 4px;
        background: linear-gradient(90deg, #fbbf24, #f6c34a, rgba(246,195,74,.15));
    }
    .spine-half .spine-node { flex: 1; min-width: 0; }
    .spine-hline { flex: 0 0 72px; min-width: 72px; }
    .spine-hline-solid    { height: 3px; background: #3b82f6; }
    .spine-hline-dashed   { height: 3px; background: repeating-linear-gradient(to right, #3b82f6 0 10px, transparent 10px 16px); }
    .spine-hline-dash-dot { height: 3px; background: repeating-linear-gradient(to right, #3b82f6 0 10px, transparent 10px 13px, #3b82f6 13px 15px, transparent 15px 20px); }
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

    /* Match public Lokasi dan Kontak layout inside admin preview */
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
        align-items: stretch;
    }
    .kontak-info-stack {
        display: grid;
        gap: 11px;
        align-content: start;
    }
    .kontak-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 11px;
    }
    .kontak-card {
        display: grid;
        grid-template-columns: 48px minmax(0, 1fr);
        gap: 14px;
        align-items: center;
        padding: 16px 18px;
        border: 1px solid rgba(225, 234, 254, .75);
        border-left: 4px solid #0047cc;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(238,244,255,.55) 0%, #fff 60%);
        box-shadow: 0 4px 18px rgba(0, 31, 84, .055);
        transition: transform .18s ease, box-shadow .18s ease;
    }
    .kontak-card:hover {
        transform: translateX(4px);
        box-shadow: 0 8px 28px rgba(0, 31, 84, .1);
    }
    .kontak-card.card-fax   { border-left-color: #667085; background: linear-gradient(135deg, rgba(241,245,249,.55) 0%, #fff 60%); }
    .kontak-card.card-email { border-left-color: #0f766e; background: linear-gradient(135deg, rgba(240,253,250,.55) 0%, #fff 60%); }
    .kontak-card.card-wa    { border-left-color: #16a34a; background: linear-gradient(135deg, rgba(240,253,244,.55) 0%, #fff 60%); }
    .kontak-card.card-hours { border-left-color: #7c3aed; background: linear-gradient(135deg, rgba(245,243,255,.55) 0%, #fff 60%); }
    .kontak-card-icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        border-radius: 14px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: 18px;
        box-shadow: 0 8px 20px rgba(0, 71, 204, .2);
        flex-shrink: 0;
    }
    .kontak-card-label {
        display: block;
        margin-bottom: 3px;
        color: #8290a3;
        font-size: 10.5px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }
    .kontak-card-value {
        display: block;
        color: #0a1f44;
        font-size: .93rem;
        font-weight: 700;
        line-height: 1.5;
    }
    .kontak-card-value a {
        color: inherit;
        text-decoration: none;
    }
    .kontak-card-value a:hover {
        text-decoration: underline;
        color: #0047cc;
    }
    .kontak-map-section {
        display: flex;
        flex-direction: column;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid #dce8fb;
        box-shadow: 0 18px 46px rgba(0, 31, 84, .1);
    }
    .kontak-map-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 20px;
        background: linear-gradient(135deg, #003cbf 0%, #0052e6 60%, #1a6af5 100%);
        color: #fff;
        font-size: 12.5px;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
        flex-shrink: 0;
    }
    .kontak-map-wrap {
        position: relative;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        background: #eef4ff;
        flex: 1;
    }
    .kontak-map-wrap iframe {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
    }
    .kontak-map-placeholder {
        display: grid;
        place-items: center;
        width: 100%;
        height: 100%;
        gap: 12px;
        color: #8290a3;
        font-size: .9rem;
        font-weight: 800;
        text-align: center;
        padding: 24px;
    }
    .kontak-cta-strip {
        border-radius: 16px;
        overflow: hidden;
        background: linear-gradient(135deg, #003cbf 0%, #0052e6 55%, #1a6af5 100%);
        box-shadow: 0 12px 32px rgba(0, 71, 204, .25);
    }
    .kontak-cta-strip-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 22px 28px;
    }
    .kontak-cta-strip-copy strong {
        display: block;
        color: #fff;
        font-size: 1rem;
        font-weight: 900;
        margin-bottom: 4px;
    }
    .kontak-cta-strip-copy span {
        display: block;
        color: rgba(255,255,255,.7);
        font-size: .87rem;
    }
    .kontak-cta {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        min-height: 44px;
        padding: 11px 22px;
        border-radius: 12px;
        background: rgba(255,255,255,.15);
        border: 1.5px solid rgba(255,255,255,.35);
        color: #fff;
        font-size: 14px;
        font-weight: 900;
        text-decoration: none;
        white-space: nowrap;
        transition: background .18s, transform .18s;
    }
    .kontak-cta:hover {
        background: rgba(255,255,255,.26);
        transform: translateY(-2px);
        color: #fff;
        text-decoration: none;
    }
    .profile-content-card.is-preview .kontak-top-grid,
    .profile-content-card.is-preview .kontak-2col {
        grid-template-columns: 1fr;
    }
    .profile-content-card.is-preview .kontak-map-section {
        order: -1;
    }
    .profile-content-card.is-preview .kontak-cta-strip-inner {
        flex-direction: column;
        align-items: flex-start;
    }
    .profile-content-card.is-preview .kontak-card {
        grid-template-columns: 42px minmax(0, 1fr);
        padding: 13px 14px;
    }
    .profile-content-card.is-preview .kontak-card-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        font-size: 16px;
    }
    @media (max-width: 860px) {
        .kontak-top-grid { grid-template-columns: 1fr; }
        .kontak-map-section { order: -1; }
        .kontak-cta-strip-inner { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 560px) {
        .kontak-map-wrap { aspect-ratio: 16 / 9; }
        .kontak-2col { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
    <section>
        <div class="panel full-card">
            <div class="page-head">
                <h3>Edit {{ $profilePage->title }}</h3>
                <a class="profile-admin-secondary" href="{{ route('admin.profile-pages.index') }}">Semua Profil</a>
            </div>

            @if (session('success'))<div class="flash-success">{{ session('success') }}</div>@endif
            @if ($errors->any())<div class="flash-error">{{ $errors->first() }}</div>@endif

            <div class="profile-edit-shell">
                <div class="profile-editor-card">
                    <form class="profile-editor" method="POST" action="{{ route('admin.profile-pages.update', $profilePage) }}">
                        @csrf
                        @method('PUT')
                        <div class="profile-form-grid">
                            <div class="profile-field">
                                <label for="profileTitle">Judul Halaman</label>
                                <input type="text" class="popup-input" id="profileTitle" name="title" value="{{ old('title', $profilePage->title) }}" placeholder="Judul" required>
                            </div>
                            <div class="profile-field">
                                <label for="profileSort">Urutan</label>
                                <input type="number" class="popup-input" id="profileSort" name="sort_order" value="{{ old('sort_order', $profilePage->sort_order) }}" min="0" max="999" placeholder="Urutan">
                            </div>
                            <div class="profile-field full">
                                <label for="profileSlug">Slug URL</label>
                                <input type="text" class="popup-input" id="profileSlug" name="slug" value="{{ old('slug', $profilePage->slug) }}" placeholder="Slug">
                                <p class="profile-field-hint">Digunakan untuk alamat halaman. Biarkan seperti ini jika tidak perlu mengubah URL.</p>
                            </div>
                        </div>
                        @if ($profilePage->slug === 'lokasi-dan-kontak')
                            @php
                                $kontakRaw  = old('content', $profilePage->content);
                                $kontakInit = [];
                                if ($kontakRaw) {
                                    $dec = json_decode($kontakRaw, true);
                                    if (is_array($dec)) $kontakInit = $dec;
                                }
                            @endphp
                            <div class="profile-field">
                                <label class="profile-editor-label">Informasi Kontak</label>
                            </div>
                            <div class="profile-field">
                                <label for="kontakAddress">Alamat</label>
                                <textarea class="popup-input" id="kontakAddress" rows="3" placeholder="Jl. ..." style="resize:vertical;min-height:72px;">{{ $kontakInit['address'] ?? '' }}</textarea>
                            </div>
                            <div class="profile-form-grid">
                                <div class="profile-field">
                                    <label for="kontakPhone">Telepon</label>
                                    <input type="text" class="popup-input" id="kontakPhone" value="{{ $kontakInit['phone'] ?? '' }}" placeholder="(021) ...">
                                </div>
                                <div class="profile-field">
                                    <label for="kontakFax">Fax</label>
                                    <input type="text" class="popup-input" id="kontakFax" value="{{ $kontakInit['fax'] ?? '' }}" placeholder="(021) ...">
                                </div>
                            </div>
                            <div class="profile-field">
                                <label for="kontakEmail">Email</label>
                                <input type="email" class="popup-input" id="kontakEmail" value="{{ $kontakInit['email'] ?? '' }}" placeholder="email@example.go.id">
                            </div>
                            <div class="profile-field">
                                <label for="kontakWhatsapp">WhatsApp</label>
                                <input type="text" class="popup-input" id="kontakWhatsapp" value="{{ $kontakInit['whatsapp'] ?? '' }}" placeholder="628123456789">
                                <p class="profile-field-hint">Nomor format internasional tanpa + (contoh: 628123456789).</p>
                            </div>
                            <div class="profile-field">
                                <label for="kontakHours">Jam Operasional</label>
                                <input type="text" class="popup-input" id="kontakHours" value="{{ $kontakInit['hours'] ?? '' }}" placeholder="Senin – Jumat, 08.00 – 16.00 WIB">
                            </div>
                            <div class="profile-field">
                                <label for="kontakMapsUrl">Link Google Maps</label>
                                <input type="url" class="popup-input" id="kontakMapsUrl" value="{{ $kontakInit['maps_url'] ?? '' }}" placeholder="https://maps.google.com/?q=...">
                                <p class="profile-field-hint">URL untuk tombol "Buka di Google Maps".</p>
                            </div>
                            <div class="profile-field">
                                <label for="kontakMapsEmbed">Google Maps Embed URL</label>
                                <input type="url" class="popup-input" id="kontakMapsEmbed" value="{{ $kontakInit['maps_embed'] ?? '' }}" placeholder="https://www.google.com/maps/embed?pb=...">
                                <p class="profile-field-hint">Buka Google Maps → Bagikan → Sematkan peta → salin URL dari atribut <code>src</code> pada iframe.</p>
                            </div>
                            <textarea id="profileContent" name="content" style="display:none">{{ $kontakRaw }}</textarea>
                        @elseif ($profilePage->slug === 'struktur-organisasi')
                            <div class="profile-field">
                                <div class="org-editor-toolbar">
                                    <label class="profile-editor-label">Anggota Struktur Organisasi</label>
                                    <span class="org-mode-badge" id="orgModeBadge">Spine</span>
                                    <button type="button" id="orgModeToggle" class="org-mode-toggle" title="Ganti mode layout">
                                        <i class="fa-solid fa-arrows-rotate"></i> Ganti Mode
                                    </button>
                                    <button type="button" id="orgAddBtn" class="org-btn-add">
                                        <i class="fa-solid fa-plus"></i> Tambah Anggota
                                    </button>
                                </div>
                                <div id="orgList" class="org-list"></div>
                                <div id="orgEditorEmpty" class="org-editor-empty">
                                    Belum ada anggota. Klik "Tambah Anggota" untuk mulai.
                                </div>
                            </div>
                            <textarea id="profileContent" name="content" style="display:none">{{ old('content', $profilePage->content) }}</textarea>
                        @else
                            <div class="profile-field">
                                <label class="profile-editor-label" for="profileContent">Konten Halaman</label>
                                <textarea class="popup-textarea" id="profileContent" name="content" placeholder="Tuliskan konten halaman di sini...">{{ old('content', $profilePage->content) }}</textarea>
                            </div>
                        @endif
                        <div class="profile-editor-actions">
                            <button type="submit" class="btn-primary">Simpan</button>
                            <a class="profile-admin-secondary" href="{{ $profilePage->publicUrl() }}" target="_blank" rel="noopener">Lihat Halaman</a>
                        </div>
                    </form>
                </div>

                <aside class="profile-preview-card" aria-label="Preview konten">
                    @if ($profilePage->slug === 'lokasi-dan-kontak')
                        <div class="profile-content-card is-preview">
                            <div class="profile-content-heading">
                                <p class="profile-content-kicker">Profil Balai Air Tanah</p>
                                <h2 class="profile-content-title" id="profilePreviewTitle">{{ old('title', $profilePage->title) }}</h2>
                            </div>
                            <div id="profilePreviewBody" style="min-height:150px;display:grid;gap:10px;"></div>
                        </div>
                        <div class="profile-content-tips">
                            <strong>Tips Lokasi dan Kontak</strong>
                            <span>Isi semua field lalu salin URL embed dari Google Maps agar peta muncul di halaman publik.</span>
                            <span>Link Google Maps digunakan untuk tombol "Buka di Google Maps" di HP pengunjung.</span>
                        </div>
                    @elseif ($profilePage->slug === 'struktur-organisasi')
                        <div class="profile-content-card is-preview">
                            <div class="profile-content-heading">
                                <p class="profile-content-kicker">Profil Balai Air Tanah</p>
                                <h2 class="profile-content-title" id="profilePreviewTitle">{{ old('title', $profilePage->title) }}</h2>
                            </div>
                            <div id="profilePreviewBody" style="min-height:150px;overflow-x:auto;">
                                <div class="org-preview-empty">Tambahkan anggota untuk melihat preview bagan.</div>
                            </div>
                        </div>
                        <div class="profile-content-tips">
                            <strong>Tips Struktur Organisasi</strong>
                            <span>Mulai dari Level 1 (Kepala), tambah Level 2, 3, dst. dengan memilih "Induk" yang tepat.</span>
                            <span>Preview diperbarui otomatis saat Anda mengedit anggota.</span>
                        </div>
                    @else
                        @include('pages.partials.profile_content_card', [
                            'title' => old('title', $profilePage->title),
                            'content' => old('content', $profilePage->content),
                            'preview' => true,
                            'showTips' => true,
                            'titleId' => 'profilePreviewTitle',
                            'bodyId' => 'profilePreviewBody',
                            'tipsTitleId' => 'profileWritingTipsTitle',
                        ])
                    @endif
                </aside>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
/* ===== Lokasi dan Kontak serializer ===== */
(function () {
    var fieldIds = { address: 'kontakAddress', phone: 'kontakPhone', fax: 'kontakFax', email: 'kontakEmail', whatsapp: 'kontakWhatsapp', hours: 'kontakHours', maps_url: 'kontakMapsUrl', maps_embed: 'kontakMapsEmbed' };
    var fields = {};
    Object.keys(fieldIds).forEach(function (key) { fields[key] = document.getElementById(fieldIds[key]); });
    var contentHidden = document.getElementById('profileContent');
    var previewBody   = document.getElementById('profilePreviewBody');
    var titleInput    = document.getElementById('profileTitle');
    var previewTitle  = document.getElementById('profilePreviewTitle');

    if (!fields.address) return; /* not on lokasi page */

    function esc(s) {
        return String(s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function attr(s) {
        return esc(s).replace(/'/g, '&#039;');
    }

    function phoneHref(value) {
        return String(value || '').replace(/[^0-9+]/g, '');
    }

    function waHref(value) {
        return String(value || '').replace(/[^0-9]/g, '');
    }

    function contactCard(label, value, iconClass, extraClass, iconStyle, linkHref, linkTarget) {
        var html = '<div class="kontak-card' + (extraClass ? ' ' + extraClass : '') + '">';
        html += '<div class="kontak-card-icon"' + (iconStyle ? ' style="' + iconStyle + '"' : '') + '><i class="' + iconClass + '"></i></div>';
        html += '<div><span class="kontak-card-label">' + esc(label) + '</span><span class="kontak-card-value">';
        if (linkHref) {
            html += '<a href="' + attr(linkHref) + '"' + (linkTarget ? ' target="_blank" rel="noopener"' : '') + '>' + esc(value) + '</a>';
        } else {
            html += esc(value);
        }
        html += '</span></div></div>';
        return html;
    }

    function renderPreview() {
        if (!previewBody) return;
        var address = fields.address ? fields.address.value.trim() : '';
        var phone = fields.phone ? fields.phone.value.trim() : '';
        var fax = fields.fax ? fields.fax.value.trim() : '';
        var email = fields.email ? fields.email.value.trim() : '';
        var whatsapp = fields.whatsapp ? fields.whatsapp.value.trim() : '';
        var hours = fields.hours ? fields.hours.value.trim() : '';
        var mapsUrl = fields.maps_url ? fields.maps_url.value.trim() : '';
        var mapsEmbed = fields.maps_embed ? fields.maps_embed.value.trim() : '';

        var infoHtml = '';
        if (address) {
            infoHtml += contactCard('Alamat', address, 'fa-solid fa-location-dot');
        }
        if (phone || whatsapp) {
            infoHtml += '<div class="kontak-2col">';
            if (phone) {
                infoHtml += contactCard('Telepon', phone, 'fa-solid fa-phone', '', '', 'tel:' + phoneHref(phone));
            }
            if (whatsapp) {
                infoHtml += contactCard('WhatsApp', whatsapp, 'fa-brands fa-whatsapp', 'card-wa', 'background:linear-gradient(135deg,#16a34a,#22c55e)', 'https://wa.me/' + waHref(whatsapp), true);
            }
            infoHtml += '</div>';
        }
        if (fax) {
            infoHtml += contactCard('Fax', fax, 'fa-solid fa-fax', 'card-fax', 'background:linear-gradient(135deg,#475467,#667085)');
        }
        if (email) {
            infoHtml += contactCard('Email', email, 'fa-solid fa-envelope', 'card-email', 'background:linear-gradient(135deg,#0f766e,#16a3e8)', 'mailto:' + email);
        }
        if (hours) {
            infoHtml += contactCard('Jam Operasional', hours, 'fa-solid fa-clock', 'card-hours', 'background:linear-gradient(135deg,#7c3aed,#0047cc)');
        }
        if (!infoHtml) {
            infoHtml = '<div class="profile-content-empty">Informasi kontak belum tersedia.</div>';
        }

        var mapHtml = '<div class="kontak-map-section">';
        mapHtml += '<div class="kontak-map-header"><i class="fa-solid fa-map-location-dot"></i>Lokasi Kami</div>';
        mapHtml += '<div class="kontak-map-wrap">';
        if (mapsEmbed) {
            mapHtml += '<iframe src="' + attr(mapsEmbed) + '" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
        } else {
            mapHtml += '<div class="kontak-map-placeholder"><i class="fa-solid fa-map-location-dot" style="font-size:2.5rem;color:#c8d7f4;"></i>Peta belum dikonfigurasi.</div>';
        }
        mapHtml += '</div></div>';

        var html = '<div class="kontak-wrap"><div class="kontak-top-grid"><div class="kontak-info-stack">' + infoHtml + '</div>' + mapHtml + '</div>';
        if (mapsUrl) {
            html += '<div class="kontak-cta-strip"><div class="kontak-cta-strip-inner">';
            html += '<div class="kontak-cta-strip-copy"><strong>Temukan kami di Google Maps</strong><span>Navigasi langsung ke lokasi Balai Air Tanah</span></div>';
            html += '<a href="' + attr(mapsUrl) + '" target="_blank" rel="noopener" class="kontak-cta"><i class="fa-solid fa-map-location-dot"></i>Buka di Google Maps</a>';
            html += '</div></div>';
        }
        html += '</div>';
        previewBody.innerHTML = html;
    }

    function serialize() {
        var data = {};
        Object.keys(fields).forEach(function (key) { if (fields[key]) data[key] = fields[key].value.trim(); });
        if (contentHidden) contentHidden.value = JSON.stringify(data);
    }

    function onInput() { serialize(); renderPreview(); }

    Object.values(fields).forEach(function (el) { if (el) el.addEventListener('input', onInput); });
    if (titleInput && previewTitle) {
        titleInput.addEventListener('input', function () { previewTitle.textContent = this.value.trim() || 'Judul Halaman'; });
    }

    renderPreview();
})();

(function () {
    var titleInput = document.getElementById('profileTitle');
    var contentInput = document.getElementById('profileContent');
    var previewTitle = document.getElementById('profilePreviewTitle');
    var previewBody = document.getElementById('profilePreviewBody');
    var writingTipsTitle = document.getElementById('profileWritingTipsTitle');
    if (!titleInput || !contentInput || !previewTitle || !previewBody) return;

    function escapeHtml(value) {
        return value
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function renderFormattedContent(value) {
        var lines = value.trim().split(/\r?\n/);
        var html = '';
        var paragraph = [];
        var list = [];
        var orderedList = [];

        function flushParagraph() {
            if (!paragraph.length) return;
            html += '<p>' + escapeHtml(paragraph.join(' ')) + '</p>';
            paragraph = [];
        }

        function flushList() {
            if (!list.length) return;
            html += '<ul>';
            list.forEach(function (item) {
                html += '<li>' + escapeHtml(item) + '</li>';
            });
            html += '</ul>';
            list = [];
        }

        function flushOrderedList() {
            if (!orderedList.length) return;
            html += '<ol>';
            orderedList.forEach(function (item) {
                html += '<li>' + escapeHtml(item) + '</li>';
            });
            html += '</ol>';
            orderedList = [];
        }

        function flushAll() {
            flushParagraph();
            flushList();
            flushOrderedList();
        }

        lines.forEach(function (line) {
            line = line.trim();
            if (!line) {
                flushAll();
                return;
            }
            if (line.indexOf('## ') === 0) {
                flushAll();
                html += '<h5>' + escapeHtml(line.slice(3).trim()) + '</h5>';
                return;
            }
            var normalizedHeading = line.replace(/:$/, '').toLowerCase();
            if (/^[A-Za-zÀ-ÿ ]+:$/.test(line) || ['visi', 'misi', 'tugas', 'fungsi'].indexOf(normalizedHeading) !== -1) {
                flushAll();
                html += '<h5>' + escapeHtml(line.replace(/:$/, '')) + '</h5>';
                return;
            }
            if (line.indexOf('- ') === 0) {
                flushParagraph();
                flushOrderedList();
                list.push(line.slice(2).trim());
                return;
            }
            var orderedMatch = line.match(/^(?:\d+|[a-zA-Z])[\.\)]\s+(.+)$/);
            if (orderedMatch) {
                flushParagraph();
                flushList();
                orderedList.push(orderedMatch[1].trim());
                return;
            }
            flushList();
            flushOrderedList();
            paragraph.push(line);
        });

        flushAll();

        return html;
    }

    function renderPreview() {
        var title = titleInput.value.trim() || 'Judul Halaman';
        previewTitle.textContent = title;
        if (writingTipsTitle) {
            writingTipsTitle.textContent = 'Saran isi ' + title;
        }
        if (typeof window._renderOrgPreview === 'function') {
            window._renderOrgPreview();
            return;
        }
        var content = contentInput.value.trim();
        previewBody.classList.toggle('has-content', Boolean(content));
        previewBody.innerHTML = content
            ? renderFormattedContent(content)
            : '<div class="profile-content-empty">Konten yang ditulis akan tampil di halaman publik.</div>';
    }

    titleInput.addEventListener('input', renderPreview);
    contentInput.addEventListener('input', renderPreview);
})();

(function () {
    var orgList      = document.getElementById('orgList');
    var orgEmpty     = document.getElementById('orgEditorEmpty');
    var orgAddBtn    = document.getElementById('orgAddBtn');
    var orgModeBadge = document.getElementById('orgModeBadge');
    var orgModeToggle= document.getElementById('orgModeToggle');
    var contentArea  = document.getElementById('profileContent');
    var previewBody  = document.getElementById('profilePreviewBody');
    if (!orgList || !contentArea) return;

    var nodes = [];
    var layoutMode = 'tree'; // 'tree' or 'spine'

    try {
        var parsed = JSON.parse(contentArea.value || '[]');
        if (Array.isArray(parsed) && parsed.length > 0) {
            nodes = parsed;
            layoutMode = nodes[0].side !== undefined ? 'spine' : 'tree';
        }
    } catch (e) {}

    function genId() {
        return 'n' + Date.now().toString(36) + Math.random().toString(36).substr(2, 5);
    }

    function esc(str) {
        return String(str || '')
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function updateModeBadge() {
        if (orgModeBadge) orgModeBadge.textContent = layoutMode === 'spine' ? 'Spine' : 'Tree';
    }

    /* ---- Tree mode helpers ---- */
    function getParentOptions(excludeId, currentParent) {
        var html = '<option value=""' + (!currentParent ? ' selected' : '') + '>— Tidak ada —</option>';
        nodes.forEach(function (n) {
            if (n.id === excludeId) return;
            var label = (n.position || 'Tanpa jabatan') + (n.name ? ' (' + n.name + ')' : '');
            html += '<option value="' + esc(n.id) + '"' + (currentParent === n.id ? ' selected' : '') + '>' + esc(label) + '</option>';
        });
        return html;
    }

    function syncParentOptions() {
        orgList.querySelectorAll('.org-row').forEach(function (row) {
            var id = row.dataset.id;
            var node = nodes.find(function (n) { return n.id === id; });
            if (!node) return;
            var sel = row.querySelector('[data-field="parent"]');
            if (!sel) return;
            var cur = sel.value;
            sel.innerHTML = getParentOptions(id, cur);
        });
    }

    /* ---- Refresh editor rows ---- */
    function refresh() {
        orgEmpty.style.display = nodes.length === 0 ? '' : 'none';
        orgList.innerHTML = '';
        nodes.forEach(function (node) {
            var row = document.createElement('div');
            row.className = 'org-row';
            row.dataset.id = node.id;

            if (layoutMode === 'spine') {
                row.innerHTML =
                    '<input type="text" class="org-input" placeholder="Nama pejabat" data-field="name" value="' + esc(node.name || '') + '">' +
                    '<input type="text" class="org-input" placeholder="Jabatan" data-field="position" value="' + esc(node.position || '') + '">' +
                    '<button type="button" class="org-btn-del" data-id="' + esc(node.id) + '">×</button>' +
                    '<div class="org-row-sub spine-sub">' +
                        '<select class="org-select" data-field="side">' +
                            '<option value="center"' + ((node.side || 'center') === 'center' ? ' selected' : '') + '>Tengah</option>' +
                            '<option value="left"'   + (node.side === 'left'   ? ' selected' : '') + '>Kiri</option>' +
                            '<option value="right"'  + (node.side === 'right'  ? ' selected' : '') + '>Kanan</option>' +
                        '</select>' +
                        '<input type="number" class="org-input" placeholder="Baris" data-field="row" value="' + (node.row || 0) + '" min="0" max="20" style="max-width:68px">' +
                        '<select class="org-select" data-field="line_style">' +
                            '<option value="solid"'    + ((node.line_style || 'solid') === 'solid'    ? ' selected' : '') + '>Solid</option>' +
                            '<option value="dashed"'   + (node.line_style === 'dashed'   ? ' selected' : '') + '>Putus-putus</option>' +
                            '<option value="dash-dot"' + (node.line_style === 'dash-dot' ? ' selected' : '') + '>Titik-garis</option>' +
                        '</select>' +
                        '<button type="button" class="org-photo-btn' + (node.photo ? ' has-photo' : '') + '" title="' + (node.photo ? 'Ganti foto' : 'Upload foto') + '">' +
                            (node.photo ? '<img src="' + esc(node.photo) + '" class="org-photo-thumb" alt="">' : '<i class="fa-solid fa-camera"></i>') +
                        '</button>' +
                    '</div>' +
                    '<input type="file" accept="image/*" class="org-photo-file" style="display:none">';
            } else {
                row.innerHTML =
                    '<input type="text" class="org-input" placeholder="Nama pejabat" data-field="name" value="' + esc(node.name || '') + '">' +
                    '<input type="text" class="org-input" placeholder="Jabatan" data-field="position" value="' + esc(node.position || '') + '">' +
                    '<button type="button" class="org-btn-del" data-id="' + esc(node.id) + '">×</button>' +
                    '<div class="org-row-sub">' +
                        '<select class="org-select" data-field="level">' +
                            '<option value="1"' + (node.level == 1 ? ' selected' : '') + '>Level 1 – Kepala</option>' +
                            '<option value="2"' + (node.level == 2 ? ' selected' : '') + '>Level 2 – Kabid/Kabag</option>' +
                            '<option value="3"' + (node.level == 3 ? ' selected' : '') + '>Level 3 – Kasubid</option>' +
                            '<option value="4"' + (node.level == 4 ? ' selected' : '') + '>Level 4 – Staf</option>' +
                        '</select>' +
                        '<select class="org-select" data-field="parent">' + getParentOptions(node.id, node.parent) + '</select>' +
                        '<input type="color" class="org-color-input" data-field="color" value="' + esc(node.color || '#0047cc') + '" title="Warna aksen">' +
                        '<label class="org-standalone-label" title="Tampilkan terpisah di bawah bagan"><input type="checkbox" class="org-checkbox" data-field="standalone"' + (node.standalone ? ' checked' : '') + '> Standalone</label>' +
                    '</div>';
            }

            /* input listeners */
            row.querySelectorAll('.org-input').forEach(function (inp) {
                inp.addEventListener('input', function () {
                    var idx = nodes.findIndex(function (n) { return n.id === node.id; });
                    if (idx === -1) return;
                    var f = this.dataset.field;
                    nodes[idx][f] = (f === 'row') ? (parseInt(this.value) || 0) : this.value;
                    if (layoutMode === 'tree') syncParentOptions();
                    renderOrgPreview();
                });
            });

            /* select listeners */
            row.querySelectorAll('.org-select').forEach(function (sel) {
                sel.addEventListener('change', function () {
                    var idx = nodes.findIndex(function (n) { return n.id === node.id; });
                    if (idx === -1) return;
                    var f = this.dataset.field;
                    if (f === 'level')       nodes[idx].level = parseInt(this.value) || 1;
                    else if (f === 'parent') nodes[idx].parent = this.value || null;
                    else                     nodes[idx][f] = this.value;
                    renderOrgPreview();
                });
            });

            /* color & standalone */
            var colorInp = row.querySelector('[data-field="color"]');
            if (colorInp) colorInp.addEventListener('input', function () {
                var idx = nodes.findIndex(function (n) { return n.id === node.id; });
                if (idx !== -1) nodes[idx].color = this.value;
                renderOrgPreview();
            });
            var chk = row.querySelector('[data-field="standalone"]');
            if (chk) chk.addEventListener('change', function () {
                var idx = nodes.findIndex(function (n) { return n.id === node.id; });
                if (idx !== -1) nodes[idx].standalone = this.checked || null;
                renderOrgPreview();
            });

            row.querySelector('.org-btn-del').addEventListener('click', function () {
                var delId = this.dataset.id;
                nodes = nodes.filter(function (n) { return n.id !== delId; });
                if (layoutMode === 'tree') nodes.forEach(function (n) { if (n.parent === delId) n.parent = null; });
                refresh();
                renderOrgPreview();
            });

            /* photo upload */
            var photoFile = row.querySelector('.org-photo-file');
            var photoBtn  = row.querySelector('.org-photo-btn');
            if (photoFile && photoBtn) {
                photoBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    photoFile.click();
                });
                photoFile.addEventListener('change', function () {
                    var file = this.files[0];
                    if (!file) return;
                    var fd = new FormData();
                    fd.append('photo', file);
                    fd.append('_token', csrfToken);
                    photoBtn.style.opacity = '.45';
                    fetch(uploadUrl, {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                        body: fd
                    })
                        .then(function (r) {
                            if (!r.ok) return r.json().then(function (e) { throw new Error(e.message || 'HTTP ' + r.status); });
                            return r.json();
                        })
                        .then(function (data) {
                            var idx = nodes.findIndex(function (n) { return n.id === node.id; });
                            if (idx !== -1) nodes[idx].photo = data.url;
                            refresh();
                            renderOrgPreview();
                        })
                        .catch(function (err) {
                            photoBtn.style.opacity = '';
                            alert('Gagal upload foto: ' + err.message);
                        });
                });
            }

            orgList.appendChild(row);
        });
        updateModeBadge();
    }

    /* ---- Photo upload ---- */
    var uploadUrl  = '{{ route("admin.profile-pages.upload-org-photo") }}';
    var csrfToken  = '{{ csrf_token() }}';

    /* ---- Tree preview ---- */
    function getInitials(n) {
        var words = (n.name || n.position || '').replace(/[,\.]+/g, ' ').trim().split(/\s+/).filter(function (w) { return w.length > 0; });
        if (words.length >= 2) return (words[0][0] + words[1][0]).toUpperCase();
        if (words.length === 1) return words[0].slice(0, 2).toUpperCase();
        return '?';
    }
    function orgCardHtml(n) {
        var nc = n.color || '#0047cc';
        var html = '<div class="org-node-wrap" style="--nc:' + esc(nc) + '">';
        html += '<div class="org-avatar">' + esc(getInitials(n)) + '</div>';
        html += '<div class="org-card">';
        if (n.name) html += '<strong class="org-name">' + esc(n.name) + '</strong>';
        html += '<span class="org-pos">' + esc(n.position || '—') + '</span>';
        html += '</div></div>';
        return html;
    }
    function buildPreviewTree(parentId) {
        var children = nodes.filter(function (n) { return (n.parent || null) === (parentId || null) && !n.standalone; });
        if (!children.length) return '';
        var html = '<ul class="org-children">';
        children.forEach(function (n) {
            html += '<li class="org-item"><div class="org-vline"></div>';
            html += orgCardHtml(n);
            var sub = buildPreviewTree(n.id);
            if (sub) html += '<div class="org-vline"></div>' + sub;
            html += '</li>';
        });
        html += '</ul>';
        return html;
    }

    /* ---- Spine preview ---- */
    function getSpineInitials(n) {
        var src = ((n.name || '') || (n.position || '')).replace(/[,\.]+/g, ' ').trim();
        var words = src.split(/\s+/).filter(function (w) { return w.length > 0; });
        if (words.length >= 2) return (words[0][0] + words[1][0]).toUpperCase();
        if (words.length >= 1) return words[0].slice(0, 2).toUpperCase();
        return '?';
    }
    function spineNodeHtml(n) {
        var hasAvatar = Boolean(n.name && n.name.trim());
        var h = '<div class="spine-node' + (hasAvatar ? ' has-avatar' : '') + '">';
        if (hasAvatar) {
            h += '<div class="spine-node-content">';
            h += '<strong>' + esc(n.name) + '</strong>';
            h += '<span>' + esc(n.position || '') + '</span>';
            h += '</div>';
            h += '<div class="spine-node-avatar">';
            h += n.photo
                ? '<img src="' + esc(n.photo) + '" class="spine-node-photo" alt="">'
                : '<div class="spine-node-initials">' + esc(getSpineInitials(n)) + '</div>';
            h += '</div>';
        } else {
            h += '<span>' + esc(n.position || '') + '</span>';
        }
        h += '</div>';
        return h;
    }
    function buildSpinePreview() {
        var rows = {};
        nodes.forEach(function (n) {
            var r = parseInt(n.row) || 0;
            if (!rows[r]) rows[r] = [];
            rows[r].push(n);
        });
        var rowKeys = Object.keys(rows).map(Number).sort(function (a, b) { return a - b; });
        if (!rowKeys.length) return '<div class="org-preview-empty">Tambahkan anggota untuk melihat preview bagan.</div>';
        var styleLabelMap = { 'solid': 'Pejabat Struktural Sesuai Permen', 'dashed': 'Pejabat Berdasarkan Keputusan Dirjen SDA', 'dash-dot': 'Pejabat Kesatkeran' };
        var html = '<div class="spine-wrap"><div class="spine-outer">';
        var firstKey = rowKeys[0];
        var lastKey = rowKeys[rowKeys.length - 1];
        rowKeys.forEach(function (rowNum) {
            var rn = rows[rowNum];
            var cNode = rn.find(function (n) { return (n.side || 'center') === 'center'; });
            var lNode = rn.find(function (n) { return n.side === 'left'; });
            var rNode = rn.find(function (n) { return n.side === 'right'; });
            if (cNode) {
                var centerClasses = ['spine-row', 'center-row'];
                if (cNode.behind) centerClasses.push('spine-row-behind');
                if (cNode.prominent) centerClasses.push('spine-row-prominent');
                if (rowNum === firstKey) centerClasses.push('is-first');
                if (rowNum === lastKey) centerClasses.push('is-last');
                html += '<div class="' + centerClasses.join(' ') + '">';
                html += '<div class="spine-spacer"></div>';
                html += '<div class="spine-ctr-cell">' + spineNodeHtml(cNode) + '</div>';
                html += '<div class="spine-spacer"></div></div>';
            } else {
                html += '<div class="spine-row branch-row">';
                html += '<div class="spine-half left' + (lNode ? '' : ' spine-half-empty') + '">';
                if (lNode) {
                    html += spineNodeHtml(lNode);
                    html += '<div class="spine-hline spine-hline-' + esc(lNode.line_style || 'solid') + '"></div>';
                }
                html += '</div>';
                html += '<div class="spine-half right' + (rNode ? '' : ' spine-half-empty') + '">';
                if (rNode) {
                    html += '<div class="spine-hline spine-hline-' + esc(rNode.line_style || 'solid') + '"></div>';
                    html += spineNodeHtml(rNode);
                }
                html += '</div></div>';
            }
        });
        html += '</div>';
        var allStyles = nodes.map(function (n) { return n.line_style || 'solid'; }).filter(function (v, i, a) { return a.indexOf(v) === i; });
        var legendStyles = allStyles.filter(function (s) { return styleLabelMap[s]; });
        if (legendStyles.length > 1) {
            html += '<div class="spine-legend"><strong>Keterangan:</strong>';
            legendStyles.forEach(function (s) {
                html += '<div class="spine-legend-item"><div class="spine-hline spine-hline-' + esc(s) + ' spine-legend-line"></div><span>: ' + esc(styleLabelMap[s] || s) + '</span></div>';
            });
            html += '</div>';
        }
        html += '</div>';
        return html;
    }

    function clipSpinePreview() {
        var outer = previewBody && previewBody.querySelector('.spine-outer');
        if (!outer) return;
        var ctrNodes = outer.querySelectorAll('.center-row .spine-node');
        if (!ctrNodes.length) return;
        var first = ctrNodes[0], last = ctrNodes[ctrNodes.length - 1];
        var oRect = outer.getBoundingClientRect();
        outer.style.setProperty('--spine-top',    (first.getBoundingClientRect().top  - oRect.top  + first.offsetHeight / 2) + 'px');
        outer.style.setProperty('--spine-bottom', (oRect.bottom - last.getBoundingClientRect().bottom + last.offsetHeight / 2)  + 'px');
    }

    function renderOrgPreview() {
        if (!previewBody) return;
        if (nodes.length === 0) {
            previewBody.innerHTML = '<div class="org-preview-empty">Tambahkan anggota untuk melihat preview bagan.</div>';
            return;
        }
        if (layoutMode === 'spine') {
            previewBody.innerHTML = buildSpinePreview();
            requestAnimationFrame(clipSpinePreview);
            return;
        }
        var roots       = nodes.filter(function (n) { return !n.parent && !n.standalone; });
        var standalones = nodes.filter(function (n) { return n.standalone; });
        var html = '<div class="org-wrap"><ul class="org-tree">';
        roots.forEach(function (root) {
            html += '<li class="org-item">' + orgCardHtml(root);
            var sub = buildPreviewTree(root.id);
            if (sub) html += '<div class="org-vline"></div>' + sub;
            html += '</li>';
        });
        html += '</ul>';
        if (standalones.length) {
            html += '<div class="org-standalone-section">';
            standalones.forEach(function (n) {
                html += '<div class="org-standalone-pill" style="background:' + esc(n.color || '#6b7280') + '">' + esc(n.position || '') + '</div>';
            });
            html += '</div>';
        }
        html += '</div>';
        previewBody.innerHTML = html;
    }

    window._renderOrgPreview = renderOrgPreview;

    /* ---- Mode toggle ---- */
    if (orgModeToggle) {
        orgModeToggle.addEventListener('click', function () {
            var newMode = layoutMode === 'spine' ? 'tree' : 'spine';
            var label = newMode === 'spine' ? 'Spine (Tulang Punggung)' : 'Tree (Pohon)';
            if (!confirm('Ganti ke mode ' + label + '? Data anggota yang ada akan dihapus.')) return;
            layoutMode = newMode;
            nodes = [];
            refresh();
            renderOrgPreview();
        });
    }

    if (orgAddBtn) {
        orgAddBtn.addEventListener('click', function () {
            if (layoutMode === 'spine') {
                var maxRow = nodes.reduce(function (m, n) { return Math.max(m, parseInt(n.row) || 0); }, -1);
                nodes.push({ id: genId(), name: '', position: '', side: 'center', row: maxRow + 1, line_style: 'solid' });
            } else {
                var defaultParent = nodes.length > 0 ? nodes[0].id : null;
                nodes.push({ id: genId(), name: '', position: '', level: nodes.length === 0 ? 1 : 2, parent: defaultParent });
            }
            refresh();
            renderOrgPreview();
        });
    }

    var form = contentArea.closest('form');
    if (form) {
        form.addEventListener('submit', function () {
            contentArea.value = JSON.stringify(nodes);
        });
    }

    refresh();
    renderOrgPreview();
})();
</script>
@endpush
