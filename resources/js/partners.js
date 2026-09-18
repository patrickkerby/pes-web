const SPEED = 28

function setup(viewport) {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  let track = viewport.querySelector('[data-track]')

  if (!track) {
    track = document.createElement('div')
    track.setAttribute('data-track', '')
    while (viewport.firstChild) {
      track.appendChild(viewport.firstChild)
    }
    viewport.appendChild(track)
  }

  track.querySelectorAll('[data-clone]').forEach((node) => node.remove())
  track.classList.remove('is-marquee')
  track.style.removeProperty('--marquee-duration')

  if (reduce) {
    return
  }

  const naturalWidth = track.scrollWidth
  const overflowing = naturalWidth > viewport.clientWidth + 1

  if (!overflowing) {
    return
  }

  for (const node of [...track.children]) {
    const clone = node.cloneNode(true)
    clone.setAttribute('data-clone', '')
    clone.setAttribute('aria-hidden', 'true')
    track.appendChild(clone)
  }

  track.classList.add('is-marquee')
  const duration = track.scrollWidth / 2 / SPEED
  track.style.setProperty('--marquee-duration', `${Math.max(duration, 12)}s`)
}

function initCredentialsMarquee() {
  const viewport = document.querySelector('.partners [data-marquee]')

  if (!viewport) {
    return
  }

  const run = () => setup(viewport)

  const resize = new ResizeObserver(run)
  resize.observe(viewport)

  viewport.querySelectorAll('img').forEach((img) => {
    if (!img.complete) {
      img.addEventListener('load', run, { once: true })
    }
  })

  run()
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initCredentialsMarquee)
} else {
  initCredentialsMarquee()
}
