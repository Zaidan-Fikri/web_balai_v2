<style>
    .profile-content-card {
        position: relative;
        overflow: hidden;
        padding: var(--profile-card-padding, 46px 52px);
        border: 1px solid rgba(0, 51, 153, .08);
        border-radius: var(--profile-card-radius, 18px);
        background:
            radial-gradient(circle at 88% 16%, rgba(22, 163, 232, .10), transparent 28%),
            radial-gradient(circle at 6% 92%, rgba(246, 195, 74, .10), transparent 28%),
            linear-gradient(135deg, rgba(255,255,255,.98), rgba(247,250,255,.98)),
            #fff;
        box-shadow: var(--profile-card-shadow, 0 22px 60px rgba(0, 31, 84, .09));
    }
    .profile-content-card::before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: var(--profile-card-top-line, 6px);
        background: linear-gradient(90deg, #0047cc, #16a3e8, #f6c34a);
    }
    .profile-content-card::after {
        content: "BAT";
        position: absolute;
        top: var(--profile-card-watermark-top, 30px);
        right: var(--profile-card-watermark-right, 38px);
        color: rgba(0, 51, 153, .032);
        font-size: var(--profile-card-watermark-size, clamp(4rem, 10vw, 8rem));
        font-weight: 900;
        letter-spacing: .02em;
        line-height: 1;
        pointer-events: none;
    }
    .profile-content-heading {
        position: relative;
        z-index: 1;
        margin-bottom: var(--profile-heading-margin, 24px);
        padding-bottom: var(--profile-heading-padding-bottom, 2px);
    }
    .profile-content-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 12px;
        color: #0047cc;
        font-size: var(--profile-kicker-size, 12px);
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }
    .profile-content-kicker::before {
        content: "";
        width: var(--profile-kicker-line, 28px);
        height: 2px;
        border-radius: 999px;
        background: #f6c34a;
    }
    .profile-content-title {
        margin: 0;
        color: #0a1f44;
        font-size: var(--profile-title-size, clamp(1.9rem, 2.8vw, 2.75rem));
        font-weight: 900;
        line-height: 1.2;
        letter-spacing: .01em;
    }
    .profile-content-body {
        position: relative;
        z-index: 1;
        max-width: 940px;
        min-height: var(--profile-body-min-height, 0);
        padding: var(--profile-body-padding, 0 0 0 22px);
        border-left: var(--profile-body-border-left, 3px solid #e8eefb);
        color: #475467;
        font-size: var(--profile-body-size, 1rem);
        line-height: 1.95;
    }
    .profile-content-body p {
        margin: 0 0 18px;
    }
    .profile-content-body p:last-child {
        margin-bottom: 0;
    }
    .profile-content-body h3,
    .profile-content-body h5 {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 30px 0 14px;
        padding: var(--profile-section-title-padding, 7px 11px);
        border: var(--profile-section-title-border, 1px solid #dce8fb);
        border-radius: 999px;
        background: var(--profile-section-title-bg, #ffffff);
        color: #0047cc;
        font-size: var(--profile-section-title-size, 1.05rem);
        font-weight: 900;
        line-height: 1.35;
        box-shadow: var(--profile-section-title-shadow, 0 8px 20px rgba(0, 31, 84, .05));
    }
    .profile-content-body h3::before,
    .profile-content-body h5::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #f6c34a;
        box-shadow: 0 0 0 4px #fff6dc;
        flex: 0 0 auto;
    }
    .profile-content-body ul,
    .profile-content-body ol {
        display: grid;
        gap: 8px;
        margin: 12px 0 22px;
        padding: 0;
        list-style: none;
    }
    .profile-content-body ol {
        counter-reset: profile-content-list;
        position: relative;
    }
    .profile-content-body li {
        position: relative;
        min-height: 40px;
        padding: var(--profile-list-item-padding, 9px 12px 9px 42px);
        border: var(--profile-list-item-border, 1px solid rgba(225, 234, 254, .82));
        border-radius: var(--profile-list-item-radius, 12px);
        background: var(--profile-list-item-bg, rgba(255,255,255,.68));
        color: #475467;
        line-height: 1.75;
        box-shadow: var(--profile-list-item-shadow, 0 8px 20px rgba(0, 31, 84, .035));
    }
    .profile-content-body li::before {
        content: "";
        position: absolute;
        top: 18px;
        left: 17px;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #f6c34a;
        box-shadow: 0 0 0 4px #fff6dc;
    }
    .profile-content-body ol li {
        counter-increment: profile-content-list;
    }
    .profile-content-body ol li::before {
        content: counter(profile-content-list);
        top: var(--profile-list-number-top, 9px);
        left: var(--profile-list-number-left, 10px);
        width: var(--profile-list-number-size, 26px);
        height: var(--profile-list-number-size, 26px);
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef4ff, #ffffff);
        border: 1px solid #dce8fb;
        box-shadow: 0 8px 16px rgba(0, 71, 204, .08);
        color: #0047cc;
        font-size: 11px;
        font-weight: 900;
    }
    .profile-content-empty {
        display: grid;
        place-items: center;
        min-height: 180px;
        padding: 22px;
        border: 1.5px dashed #c8d7f4;
        border-radius: 14px;
        background: #f7faff;
        color: #8290a3;
        text-align: center;
        font-weight: 800;
    }
    .profile-content-tips {
        position: relative;
        z-index: 1;
        display: grid;
        gap: 8px;
        margin-top: 24px;
        padding: 16px 18px 16px 44px;
        border: 1px solid #e1eafe;
        border-radius: 14px;
        background:
            linear-gradient(180deg, rgba(255,255,255,.96) 0%, rgba(247,250,255,.96) 100%);
        box-shadow: 0 12px 28px rgba(0, 31, 84, .045);
    }
    .profile-content-tips::before {
        content: "";
        position: absolute;
        top: 17px;
        left: 17px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #f6c34a;
        box-shadow: 0 0 0 5px #fff6dc;
    }
    .profile-content-tips strong {
        color: #0a1f44;
        font-size: 13px;
        font-weight: 900;
    }
    .profile-content-tips span {
        display: block;
        color: #667085;
        font-size: 12px;
        line-height: 1.55;
    }
    .profile-content-card.is-preview {
        --profile-card-padding: 30px 30px 26px;
        --profile-card-radius: 16px;
        --profile-card-shadow: 0 18px 46px rgba(0, 31, 84, .08);
        --profile-card-top-line: 5px;
        --profile-card-watermark-top: 24px;
        --profile-card-watermark-right: 22px;
        --profile-card-watermark-size: 4.8rem;
        --profile-heading-margin: 22px;
        --profile-heading-padding-bottom: 0;
        --profile-kicker-size: 11px;
        --profile-kicker-line: 24px;
        --profile-title-size: 1.78rem;
        --profile-body-size: 13.5px;
        --profile-body-padding: 0 0 0 18px;
        --profile-body-min-height: 190px;
        --profile-section-title-size: .86rem;
        --profile-section-title-padding: 7px 10px;
        --profile-list-item-padding: 8px 10px 8px 42px;
        --profile-list-number-top: 8px;
        --profile-list-number-left: 9px;
        --profile-list-number-size: 24px;
    }
    @media (max-width: 640px) {
        .profile-content-card {
            padding: 28px 22px;
        }
        .profile-content-body {
            padding-left: 0;
            border-left: 0;
        }
    }
</style>
