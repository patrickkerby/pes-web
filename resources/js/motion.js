function prefersReducedMotion() {
  return window.matchMedia('(prefers-reduced-motion: reduce)').matches
}

function initEnter() {
  const nodes = document.querySelectorAll('[data-enter]')

  if (!nodes.length) {
    return
  }

  if (prefersReducedMotion()) {
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

function initHeroParallax() {
  const hero = document.querySelector('.hero')
  const next = document.querySelector('.beyond')

  if (!hero || prefersReducedMotion()) {
    return
  }

  let ticking = false

  const update = () => {
    ticking = false
    const rect = hero.getBoundingClientRect()

    if (rect.bottom <= 0) {
      return
    }

    const scrolled = Math.max(-rect.top, 0)

    hero.style.setProperty('--hero-bg-y', `${(scrolled * 0.4).toFixed(1)}px`)
    hero.style.setProperty('--hero-mark-y', `${(scrolled * 0.07).toFixed(1)}px`)

    if (next) {
      next.style.setProperty('--hero-overlap', `${Math.min(scrolled * 0.07, 32).toFixed(1)}px`)
    }
  }

  const onScroll = () => {
    if (ticking) {
      return
    }

    ticking = true
    requestAnimationFrame(update)
  }

  window.addEventListener('scroll', onScroll, { passive: true })
  update()
}

function initMotion() {
  initEnter()
  initHeroParallax()
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initMotion)
} else {
  initMotion()
}
