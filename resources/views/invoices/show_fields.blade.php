<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item">
        <a href="{{ route('invoices.show',['invoice' => $invoice->id, 'group' => 'invoice_details']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'invoice_details' || !isset($groupName)) ? 'active' : ''}}">
            {{ __('messages.invoice.invoice_details') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('invoices.show',['invoice' => $invoice->id, 'group' => 'payments']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'payments') ? 'active' : ''}}">
            {{ __('messages.invoice.payments') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('invoices.show',['invoice' => $invoice->id, 'group' => 'tasks']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'tasks') ? 'active' : ''}}">
            {{ __('messages.tasks') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('invoices.show',['invoice' => $invoice->id, 'group' => 'reminders']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'reminders') ? 'active' : ''}}">
            {{ __('messages.reminders') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('invoices.show',['invoice' => $invoice->id, 'group' => 'notes']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'notes') ? 'active' : ''}}">
            {{ __('messages.notes') }}
        </a>
    </li>
</ul>
<br>
@yield('section')
