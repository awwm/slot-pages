# Slot Pages

A WordPress plugin to manage and display slot pages using Gutenberg blocks.  
It provides two reusable blocks:
- **Slot Grid Block** — display a customizable grid of slots.
- **Slot Detail Block** — display details of a single slot.

---

## Included Files & Features

- Custom Post Type → Registers slot post type.

- Custom Fields → Provider, RTP, wagers, star rating.

- Gutenberg Blocks → Slot Grid & Slot Detail.

- REST API Endpoints → Exposes slot data for external use.

- Admin Enhancements → Custom columns in the admin slot list.

---

## Installation & Usage

### For Normal Use (no development)

1. **Download the plugin ZIP file** from the repository or release page.
2. Go to your WordPress admin → **Plugins → Add New → Upload Plugin**.
3. Upload the ZIP file, install, and activate.
4. You will see a new **Slots** section in the WordPress admin.
5. Add new slot posts under **Slots → Add New**, filling in:
   - Title
   - Featured Image
   - Provider (meta)
   - RTP (meta)
   - Minimum/Maximum Wager (meta)
   - Star Rating (meta)

---

## Gutenberg Blocks Provided

### Slot Grid Block

- Add this block to any page/post.
- Configure:
  - Number of slots (`limit`)
  - Sorting (`recent` or `random`)
  - Grid columns
  - Title, star, button colors
  - Font sizes

It automatically pulls the latest slot posts.

---

### Slot Detail Block

- Add this block to a **single slot** page or template.
- It shows:
  - Slot title, image, provider, star rating, wager limits, RTP.
- Works best in single templates for the `slot` post type.

---

## Using with Full Site Editing (FSE)

If you use a block-based theme:
1. Go to **Appearance → Editor**.
2. Edit or create:
   - A **Single** template for `slot` posts → insert the **Slot Detail Block**.
   - An **Archive** or custom page template → insert the **Slot Grid Block**.
3. Save and publish.

Now your slot post types will use block-based layouts.

---

## For Developers or Extending Functionality

If you want to develop or modify the plugin:

1. Clone or download the repository:
   ```bash
   git clone https://github.com/awwm/slot-pages.git
   cd slot-pages

2. Install dependencies:
   ```bash
   npm install

3. Build the block scripts:
   ```bash
   npm run build


