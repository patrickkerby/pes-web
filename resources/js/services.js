const FOCUSABLE = 'a[href], button:not([disabled]), textarea, input, select, [tabindex]:not([tabindex="-1"])'

function initServices() {
  const layer = document.querySelector('[data-service-layer]')

  if (!layer) {
    return
  }

  document.body.appendChild(layer)

  const panel = layer.querySelector('[data-panel]')
  const backdrop = layer.querySelector('[data-backdrop]')
  const closeBtn = layer.querySelector('[data-close]')
  const triggers = [...document.querySelectorAll('[data-service]')]
  const articles = [...layer.querySelectorAll('[data-service-panel]')]
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  let lastFocus = null
  let closing = false
  let closeTimer = 0

  const showArticle = (slug) => {
    articles.forEach((article) => {
      const match = article.getAttribute('data-service-panel') === slug
      article.hidden = !match
    })

    const active = articles.find((article) => !article.hidden)
    const heading = active?.querySelector('h3')

    if (heading?.id) {
      panel.setAttribute('aria-labelledby', heading.id)
    }
  }

  const open = (slug, pushHash = true) => {
    const exists = articles.some((article) => article.getAttribute('data-service-panel') === slug)

    if (!exists) {
      return
    }

    closing = false
    window.clearTimeout(closeTimer)
    lastFocus = document.activeElement
    showArticle(slug)
    layer.classList.add('is-open')
    panel.setAttribute('aria-hidden', 'false')
    document.documentElement.style.overflow = 'hidden'
    closeBtn?.focus()

    if (pushHash) {
      history.pushState({ service: slug }, '', `#service-${slug}`)
    }
  }

  const close = (clearHash = true) => {
    if (!layer.classList.contains('is-open') || closing) {
      return
    }

    closing = true
    layer.classList.remove('is-open')
    panel.setAttribute('aria-hidden', 'true')

    const finish = () => {
      if (!closing) {
        return
      }

      closing = false
      window.clearTimeout(closeTimer)
      document.documentElement.style.overflow = ''

      if (lastFocus?.focus) {
        lastFocus.focus()
      }
    }

    if (reduce) {
      finish()
    } else {
      closeTimer = window.setTimeout(finish, 700)
    }

    if (clearHash && location.hash.startsWith('#service-')) {
      history.pushState({}, '', location.pathname + location.search)
    }
  }

  const openFromHash = () => {
    const hash = location.hash.replace('#service-', '')

    if (hash && hash !== location.hash) {
      open(hash, false)
      return
    }

    close(false)
  }

  triggers.forEach((button) => {
    button.addEventListener('click', () => open(button.getAttribute('data-service')))
  })

  backdrop?.addEventListener('click', () => close())
  closeBtn?.addEventListener('click', () => close())

  document.addEventListener('keydown', (event) => {
    if (!layer.classList.contains('is-open')) {
      return
    }

    if (event.key === 'Escape') {
      close()
      return
    }

    if (event.key !== 'Tab') {
      return
    }

    const nodes = [closeBtn, ...panel.querySelectorAll(FOCUSABLE)].filter(Boolean)
    const first = nodes[0]
    const last = nodes[nodes.length - 1]

    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault()
      last.focus()
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault()
      first.focus()
    }
  })

  window.addEventListener('popstate', openFromHash)
  openFromHash()
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initServices)
} else {
  initServices()
}
