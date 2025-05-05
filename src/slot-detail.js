import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

registerBlockType('slot-pages/slot-detail', {
    title: __('Slot Detail', 'slot-pages'),
    icon: 'info-outline',
    category: 'widgets',
    edit() {
        return <p>{__('Slot Detail Block (preview in frontend)', 'slot-pages')}</p>;
    },
    save() {
        return null; // Rendered in PHP
    },
});
