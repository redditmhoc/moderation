<div>
    <h3 class="ui header">Export mutes to .csv</h3>
    <button wire:loading.remove="export" wire:click="export" class="ui primary button">Download</button>
    <div wire:loading="export">
        <div class="ui icon message">
            <i class="notched circle loading icon"></i>
            <div class="content">
                <div class="header">
                    Just one second
                </div>
                <p>We're fetching that content for you.</p>
            </div>
        </div>
    </div>
</div>
