# Admin Panel Design Plan — Multichannel Agent Console

*For the multi-tenant SaaS where businesses build AI agents that message clients over SMS, WhatsApp, and Messenger.*

## 1. Who this is for, and what it needs to do

The user is a business owner or their staff — not a developer. They open this panel to answer three questions, in order of frequency:

1. Is my agent working right now?
2. What is it saying to my customers?
3. If something's wrong, can I fix it in under a minute?

Everything in this plan is organized around making those three questions fast to answer. This is an operations console, not a marketing-style dashboard — closer in feeling to a calm POS or booking system than a "developer AI tool."

## 2. Design tokens

Avoiding the purple-gradient "AI SaaS" look on purpose — it's the fastest way for this product to look like every other agent wrapper on the market.

**Color**
| Token | Hex | Use |
|---|---|---|
| `ink` | `#1A1D1E` | Primary text |
| `paper` | `#F7F6F3` | App background |
| `surface` | `#FFFFFF` | Cards, panels, table rows |
| `brand` | `#2F5D50` | Primary actions, active nav, brand mark |
| `accent` | `#C4622D` | Reserved for "live" states only — agent actively responding |
| `line` | `#E4E1DA` | Hairline borders/dividers |
| `success` `#3F7A5C` · `error` `#B23A3A` · `pending` `#B8862B` | | Status only, never decorative |

**Type**
- UI text: Inter or IBM Plex Sans, weights 400/500/600 only
- Data (phone numbers, message IDs, timestamps): JetBrains Mono — used because these are a different *kind* of data, not for flavor
- No tracked-out uppercase labels, no em-dash meta strings, no single-word accent styling in headings

**Shape & elevation**
- `rounded-md` (6px) — inputs, buttons
- `rounded-lg` (10px) — cards, modals
- Sidebar, topbar, and table containers stay square — radius signals "clickable," not decoration
- Hairline borders over drop shadows everywhere possible; one soft shadow reserved for modals/popovers only

**Motion**
- One deliberate moment: new inbound message sliding into the Inbox list
- Everything else (hovers, opens, toggles) is a fast 120–150ms state change, not a designed "entrance"

## 3. Layout

```
┌──────────┬─────────────────────────────────────────┐
│  Sidebar │ Topbar: tenant name · search · profile   │
│  (240px, │───────────────────────────────────────────│
│  collap- │                                           │
│  sible)  │           Main content area               │
│          │           (12-col grid, left-aligned)     │
│  Agents  │                                           │
│  Inbox   │                                           │
│  Flows   │                                           │
│  Contacts│                                           │
│  Channels│                                           │
│  Billing │                                           │
│  Settings│                                           │
└──────────┴─────────────────────────────────────────┘
```
- Left-aligned content throughout — this is a working tool, not a landing page
- Sidebar collapses to a 64px icon rail on smaller screens, never hides entirely on desktop
- Main content max-width capped (~1200px) on very wide screens so tables and forms don't stretch into unreadable line lengths

## 4. Information architecture

1. **Dashboard** — agent health per channel (connected / responding / down), conversations needing human takeover, today's volume, recent failures. Nothing here that isn't actionable.
2. **Inbox** — unified thread view across SMS/WhatsApp/Messenger. List + conversation pane, like a real inbox. Filters: channel, AI-handled vs. escalated, unread. This is the highest-traffic screen — gets the most design attention.
3. **Agents** — per-tenant list of configured agents: connected channels, active flow, tone/style settings, pause/resume toggle front and center (this is the "panic button" control).
4. **Flows** — trigger → response → escalation logic, built as structured forms (trigger type, conditions, actions) rather than a drag-and-drop canvas. Faster to ship well, and most SMB users don't need node-graph complexity.
5. **Contacts** — customer list with per-contact conversation history and channel preference.
6. **Channels** — connection status for SMS number, WhatsApp Business, Messenger. Since tenants pay Meta directly, this screen states plainly "connected to your own Meta Business account" — never implies you're billing them for message costs.
7. **Billing** — the tenant's own subscription/usage, kept visually and structurally separate from Meta's charges.
8. **Settings** — tenant profile, team members, notification preferences.

## 5. Component patterns

- Status shown as a small solid dot + label text, never a colored pill on every row — pills-everywhere is a template tell and adds visual noise at scale.
- Tables use `divide-y divide-line` row separators, not individual shadowed cards per row.
- Every empty state: one sentence of direction + one primary action, in plain product voice. Example: "No conversations yet. Connect a channel to start receiving messages." No mascot illustration.
- Every error state says what happened and what to do next — never an apology, never vague.
- Buttons are named for what they do, and that name follows through: a button that says "Pause agent" produces a toast that says "Agent paused," not "Update successful."

## 6. Accessibility & quality floor

- Visible keyboard focus rings on every interactive element (`focus-visible` outlines, not removed via `outline-none` without a replacement)
- Color is never the only signal for status — always paired with text or an icon
- Responsive down to a single-column mobile layout for Inbox and Dashboard, since staff will check this from a phone
- Respect `prefers-reduced-motion`

## 7. Build order

1. Tailwind tokens (colors, type scale, spacing) into existing config
2. Shell: sidebar + topbar + routing skeleton
3. Dashboard — cheapest screen to validate the visual language on
4. Inbox — most complex, most valuable to get right
5. Agents → Channels → Flows → Contacts → Billing → Settings
