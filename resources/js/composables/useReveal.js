import { onMounted, onBeforeUnmount } from 'vue';

/**
 * Révèle les éléments portant la classe `.reveal` lorsqu'ils entrent dans
 * le viewport. Sans IntersectionObserver, tout reste simplement visible.
 */
export function useReveal() {
    let observer;

    onMounted(() => {
        if (typeof IntersectionObserver === 'undefined') {
            document.querySelectorAll('.reveal').forEach((el) => el.classList.add('is-visible'));

            return;
        }

        observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.1, rootMargin: '0px 0px -32px 0px' },
        );

        document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
    });

    onBeforeUnmount(() => observer?.disconnect());
}
