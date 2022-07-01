<div>
    <form wire:submit.prevent="save" class="ui form">
        @if (session()->has('issue-report-saved'))
            <div class="ui positive icon message">
                <i class="check icon"></i>
                <div class="content">
                    <div class="header">Sent!</div>
                    <p>It will be reviewed by the Developers in time.</p>
                </div>
            </div>
        @else
            @if ($errors->any())
                <div class="ui negative message">
                    <i class="close icon"></i>
                    <div class="header">
                        Errors sending report
                    </div>
                    <ul class="ui list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="ui divider"></div>
            @endif
            <div class="field">
                <label for="page_url">Relevant page URL</label>
                <input type="url" wire:model="pageUrl" id="page_url" placeholder="https://moderation.mhoc.so.uk/site/...">
            </div>
            <div class="field">
                <label for="content">Your message</label>
                <textarea wire:model="content" id="content" placeholder="What is broken and steps to reproduce"></textarea>
            </div>
            <button type="submit" wire:loading.class="disabled loading" class="ui mhoc icon button">
                Send report
            </button>
        @endif
    </form>
</div>
