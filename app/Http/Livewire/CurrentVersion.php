<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class CurrentVersion extends Component
{
    public string $version;

    public const GITHUB_API_URI = "https://api.github.com";

    public function mount()
    {
        if (config('app.env') == 'local') {
            $this->version = "Development";
            return;
        } elseif (!config('app.github.organisation_name') || !config('app.github.repository_name')) {
            $this->version = "Unknown";
            return;
        }

        $tag = Cache::remember(key: 'git-tag', ttl: now()->addHours(6), callback: function () {
            $response = Http::timeout(10)->get(
                $this::GITHUB_API_URI
                . "/repos/"
                . config('app.github.organisation_name')
                . "/"
                . config('app.github.repository_name')
                . "/tags"
            );

            if (!$response->successful() || !$response->json()[0]['name']) {
                return "Unknown";
            }

            return $response->json()[0]['name'];
        });

        if ($tag) {
            $this->version = $tag;
        }
    }

    public function render(): string
    {
        return <<<'blade'
            <span>
                {{ $version ?? "Loading..." }}
            </span>
blade;
    }
}
