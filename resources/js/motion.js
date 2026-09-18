function initMotion() {
  const nodes = document.querySelectorAll('[data-enter]')

  if (!nodes.length) {
    return
  }

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    nodes.forEach((node) => node.classList.add('is-in'))
    return
  }

  document.documentElement.classList.add('has-motion')

  const io = new IntersectionObserver(
    (entries) => {
      for (const entry of entries) {
        if (!entry.isIntersecting) {
          continue
        }

        entry.target.classList.add('is-in')
        io.unobserve(entry.target)
      }
    },
    { threshold: 0.2, rootMargin: '0px 0px -12% 0px' }
  )

  nodes.forEach((node) => io.observe(node))
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initMotion)
} else {
  initMotion()
}
