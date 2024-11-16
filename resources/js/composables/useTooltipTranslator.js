export default function useTooltipTranslator() {
    const translateTooltip = (tooltip, effectBurn) => {
        if (!tooltip) return '';

        // Replace {{ eN }} placeholders.
        const processedTooltip = tooltip.replace(
            /\{\{\s*e(\d+)\s*\}\}/g,
            (_, index) => {
                return effectBurn[index] || ''; // Replace with value or empty if not found
            },
        );

        // Handle HTML-like tags (e.g., <status>, <magicDamage>)
        let finalTooltip = processedTooltip.replace(
            /<(\w+)>(.*?)<\/\1>/g,
            (_, tag, content) => {
                switch (tag) {
                    case 'status':
                        return `<span class="text-yellow-300">${content}</span>`;
                    case 'magicDamage':
                        return `<span class="text-blue-400">${content}</span>`;
                    default:
                        return content; // Default to no formatting
                }
            },
        );

        return finalTooltip;
    };

    return {
        translateTooltip,
    };
}
