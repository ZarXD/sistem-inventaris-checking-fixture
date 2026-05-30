<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn (): HtmlString => new HtmlString(<<<'HTML'
            <style>
                /* ============================================================
                   NIFCO — Corporate Login Page Styles
                   Inspired by: Microsoft, Google Workspace, Salesforce
                   ============================================================ */

                /* -- Disable scroll on login page -- */
                html:has(.fi-auth-layout),
                body:has(.fi-auth-layout) {
                    overflow: hidden !important;
                    height: 100% !important;
                }

                .fi-auth-layout {
                    overflow: hidden !important;
                    height: 100dvh !important;
                }

                /* -- Background overlay: subtle dark vignette -- */
                .fi-auth-layout.media-cover .fi-auth-media-overlay {
                    background: linear-gradient(
                        160deg,
                        rgba(0, 0, 0, 0.60) 0%,
                        rgba(0, 0, 0, 0.30) 60%,
                        rgba(0, 0, 0, 0.50) 100%
                    ) !important;
                    backdrop-filter: blur(4px) !important;
                }

                /* -- Layout: center card vertically & horizontally -- */
                .fi-auth-layout.media-cover {
                    align-items: center !important;
                    justify-content: center !important;
                }

                .fi-auth-layout.media-cover .fi-auth-content-section {
                    display: flex !important;
                    flex-direction: column !important;
                    align-items: center !important;
                    justify-content: center !important;
                    padding: 1.5rem !important;
                    min-height: 100dvh !important;
                    width: 100% !important;
                }

                /* -- Card: clean frosted glass, corporate proportions -- */
                .fi-auth-layout.media-cover .fi-auth-card {
                    width: 100% !important;
                    max-width: 400px !important;
                    background: rgba(10, 10, 15, 0.72) !important;
                    backdrop-filter: blur(24px) saturate(160%) !important;
                    -webkit-backdrop-filter: blur(24px) saturate(160%) !important;
                    border: 1px solid rgba(255, 255, 255, 0.10) !important;
                    border-radius: 1rem !important;
                    box-shadow:
                        0 24px 64px rgba(0, 0, 0, 0.50),
                        0 4px 16px rgba(0, 0, 0, 0.30),
                        inset 0 1px 0 rgba(255, 255, 255, 0.08) !important;
                    padding: 2.25rem 2rem !important;
                }

                /* -- Logo above card: centered & spaced -- */
                .fi-auth-layout.media-cover .fi-auth-content-section > *:first-child {
                    margin-bottom: 10 !important;
                }

                /* -- Header block: center align -- */
                .fi-auth-layout .fi-simple-header {
                    align-items: center !important;
                    text-align: center !important;
                    margin-bottom: 1.75rem !important;
                }

                /* -- App name: small, muted, uppercase tracking -- */
                .fi-auth-layout .fi-simple-header-subheading {
                    display: block !important;
                    color: rgba(255, 255, 255, 0.50) !important;
                    font-size: 0.7rem !important;
                    font-weight: 500 !important;
                    letter-spacing: 0.10em !important;
                    text-transform: uppercase !important;
                    margin-bottom: 0.5rem !important;
                    order: -1 !important;
                }

                /* -- "Sign in" heading: large, white, tight -- */
                .fi-auth-layout .fi-simple-header-heading {
                    color: #ffffff !important;
                    font-size: 1.75rem !important;
                    font-weight: 700 !important;
                    letter-spacing: -0.03em !important;
                    line-height: 1.2 !important;
                    text-shadow: none !important;
                }

                /* -- Field labels: clean, lighter weight -- */
                .fi-auth-layout .fi-fo-field-wrp > div > label,
                .fi-auth-layout .fi-fo-field-wrp label {
                    color: rgba(255, 255, 255, 0.70) !important;
                    font-size: 0.8rem !important;
                    font-weight: 500 !important;
                    letter-spacing: 0.01em !important;
                    margin-bottom: 0.35rem !important;
                }

                /* -- Input wrapper -- */
                .fi-auth-layout .fi-input-wrp {
                    background: rgba(255, 255, 255, 0.06) !important;
                    border: 1px solid rgba(255, 255, 255, 0.12) !important;
                    border-radius: 0.5rem !important;
                    transition: border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease !important;
                    overflow: hidden !important;
                }

                .fi-auth-layout .fi-input-wrp:focus-within {
                    background: rgba(255, 255, 255, 0.09) !important;
                    border-color: rgba(255, 121, 0, 0.70) !important;
                    box-shadow: 0 0 0 3px rgba(255, 121, 0, 0.15) !important;
                }

                /* -- Input text -- */
                .fi-auth-layout .fi-input {
                    background: transparent !important;
                    border: none !important;
                    color: #ffffff !important;
                    font-size: 0.9rem !important;
                    padding: 0.65rem 0.75rem !important;
                    box-shadow: none !important;
                }

                .fi-auth-layout .fi-input::placeholder {
                    color: rgba(255, 255, 255, 0.25) !important;
                }

                .fi-auth-layout .fi-input:focus {
                    box-shadow: none !important;
                    outline: none !important;
                }

                /* -- Password toggle icon -- */
                .fi-auth-layout .fi-input-wrp button {
                    color: rgba(255, 255, 255, 0.40) !important;
                    transition: color 0.15s !important;
                }

                .fi-auth-layout .fi-input-wrp button:hover {
                    color: rgba(255, 255, 255, 0.80) !important;
                }

                /* -- "Remember me" checkbox label -- */
                .fi-auth-layout .fi-checkbox-label,
                .fi-auth-layout [class*="checkbox"] label {
                    color: rgba(255, 255, 255, 0.60) !important;
                    font-size: 0.82rem !important;
                }

                /* -- Links (forgot password, etc) -- */
                .fi-auth-layout a {
                    color: rgba(255, 150, 50, 0.90) !important;
                    font-size: 0.82rem !important;
                    text-decoration: none !important;
                    transition: color 0.15s !important;
                }

                .fi-auth-layout a:hover {
                    color: #ff7900 !important;
                }

                /* -- Submit button: full width, brand orange -- */
                .fi-auth-layout .fi-btn-primary,
                .fi-auth-layout [type="submit"] {
                    width: 100% !important;
                    background: #ff7900 !important;
                    background-image: linear-gradient(135deg, #ff8c1a 0%, #e56d00 100%) !important;
                    border: none !important;
                    border-radius: 0.5rem !important;
                    color: #ffffff !important;
                    font-size: 0.9rem !important;
                    font-weight: 600 !important;
                    letter-spacing: 0.02em !important;
                    padding: 0.7rem 1.5rem !important;
                    box-shadow: 0 4px 16px rgba(255, 121, 0, 0.35) !important;
                    transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease !important;
                    cursor: pointer !important;
                }

                .fi-auth-layout .fi-btn-primary:hover,
                .fi-auth-layout [type="submit"]:hover {
                    transform: translateY(-1px) !important;
                    box-shadow: 0 8px 24px rgba(255, 121, 0, 0.50) !important;
                    filter: brightness(1.08) !important;
                }

                .fi-auth-layout .fi-btn-primary:active,
                .fi-auth-layout [type="submit"]:active {
                    transform: translateY(0) !important;
                    box-shadow: 0 2px 8px rgba(255, 121, 0, 0.30) !important;
                    filter: brightness(0.97) !important;
                }

                /* -- Field spacing -- */
                .fi-auth-layout .fi-fo-field-wrp {
                    margin-bottom: 1rem !important;
                }

                /* -- Divider / separator between fields & button -- */
                .fi-auth-layout .fi-btn-primary,
                .fi-auth-layout [type="submit"] {
                    margin-top: 0.5rem !important;
                }

                /* ── Responsive ────────────────────────────── */
                @media (max-width: 480px) {
                    .fi-auth-layout.media-cover .fi-auth-card {
                        padding: 1.75rem 1.25rem !important;
                        border-radius: 0.875rem !important;
                        max-width: 100% !important;
                    }

                    .fi-auth-layout .fi-simple-header-heading {
                        font-size: 1.5rem !important;
                    }
                }

                @media (min-width: 481px) and (max-width: 768px) {
                    .fi-auth-layout.media-cover .fi-auth-card {
                        max-width: 360px !important;
                    }
                }
            </style>
            HTML)
        );
    }
}

