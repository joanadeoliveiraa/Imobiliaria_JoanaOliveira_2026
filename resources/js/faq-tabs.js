export default function faqTabs() {
    return {
        active: 0,
        navigate(event, index, count) {
            const targets = {
                ArrowRight: (index + 1) % count,
                ArrowDown: (index + 1) % count,
                ArrowLeft: (index - 1 + count) % count,
                ArrowUp: (index - 1 + count) % count,
                Home: 0,
                End: count - 1,
            };
            if (!(event.key in targets)) return;
            event.preventDefault();
            this.active = targets[event.key];
            document.getElementById(`faq-tab-${this.active}`)?.focus();
        },
    };
}
