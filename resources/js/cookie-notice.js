export const CHOICE_KEY = 'olive-cookie-choice-v1';
export const CHOICE_LIFETIME = 180 * 24 * 60 * 60 * 1000;

export default function cookieNotice() {
    return {
        visible: false,
        storageFailed: false,
        returnFocus: null,
        init() {
            try {
                const choice = JSON.parse(localStorage.getItem(CHOICE_KEY));
                this.visible = !(choice?.version === 1 && choice?.necessaryOnly === true
                    && Number.isFinite(choice.expiresAt) && choice.expiresAt > Date.now()
                    && choice.expiresAt <= Date.now() + CHOICE_LIFETIME);
            } catch {
                this.visible = true;
            }
        },
        open() {
            this.returnFocus = document.activeElement;
            this.storageFailed = false;
            this.visible = true;
            this.$nextTick(() => requestAnimationFrame(() => this.$refs.heading.focus()));
        },
        save() {
            try {
                localStorage.setItem(CHOICE_KEY, JSON.stringify({
                    version: 1, necessaryOnly: true, expiresAt: Date.now() + CHOICE_LIFETIME,
                }));
            } catch {
                this.storageFailed = true;
                return;
            }
            this.visible = false;
            if (this.returnFocus?.isConnected) this.returnFocus.focus();
        },
    };
}
