import mapboxgl from 'mapbox-gl'
import 'mapbox-gl/dist/mapbox-gl.css'
import { contactMapStyle } from './map-style'

const EDMONTON = [-113.4938, 53.5461]

const BOUNDS = [
  [-126, 48.7],
  [-103.6, 58.4],
]

const REGIONS = [
  { label: 'British Columbia', lngLat: [-123.9, 52.7] },
  { label: 'Alberta', lngLat: [-114.8, 55.35] },
  { label: 'Saskatchewan', lngLat: [-105.7, 54.15] },
]

const CITIES = [
  { label: 'Edmonton', lngLat: EDMONTON, home: true },
  { label: 'Calgary', lngLat: [-114.0719, 51.0447] },
  { label: 'Vancouver', lngLat: [-123.1207, 49.2827] },
]

const RINGS = [
  { radius: '4.6rem', start: -18, end: 312, step: 24 },
  { radius: '8.8rem', start: 22, end: 308, step: 18 },
  { radius: '13.6rem', start: -38, end: 248, step: 16 },
]

function rangeTicks(map, layer) {
  const root = document.createElement('div')
  root.setAttribute('data-range', '')

  RINGS.forEach((ring, index) => {
    const band = document.createElement('b')
    band.style.setProperty('--radius', ring.radius)
    band.style.setProperty('--delay', `${index * 1.15}s`)

    for (let angle = ring.start; angle <= ring.end; angle += ring.step) {
      const tick = document.createElement('i')
      const heading = ((angle % 360) + 360) % 360
      const cardinal = [0, 90, 180, 270].some((point) => Math.abs(heading - point) < 10)

      if (cardinal) {
        tick.setAttribute('data-cardinal', '')
      }

      tick.style.setProperty('--angle', `${angle}deg`)
      band.appendChild(tick)
    }

    root.appendChild(band)
  })

  pin(map, layer, EDMONTON, root)
}

function pin(map, layer, lngLat, node, anchor = 'center') {
  layer.appendChild(node)
  node.dataset.anchor = anchor

  const update = () => {
    const point = map.project(lngLat)
    node.style.left = `${point.x}px`
    node.style.top = `${point.y}px`
  }

  map.on('move', update)
  map.on('resize', update)
  update()
}

function fit(map) {
  map.fitBounds(BOUNDS, {
    padding: { top: 28, bottom: 20, left: 24, right: 40 },
    duration: 0,
  })
}

function hideMapboxLabels(map) {
  for (const layer of map.getStyle().layers ?? []) {
    if (layer.type === 'symbol') {
      map.setLayoutProperty(layer.id, 'visibility', 'none')
    }
  }
}

export function initContactMap(root) {
  const token = root.dataset.token

  if (!token) {
    console.warn('Contact map needs MAPBOX_TOKEN in .env')
    return
  }

  mapboxgl.accessToken = token

  const layer = document.createElement('div')
  layer.setAttribute('data-labels', '')
  root.after(layer)

  const studioStyle = root.dataset.style
  const map = new mapboxgl.Map({
    container: root,
    style: studioStyle || contactMapStyle,
    center: EDMONTON,
    zoom: 5,
    interactive: false,
    attributionControl: { compact: true },
    fadeDuration: 0,
  })

  let decorated = false

  const decorate = () => {
    fit(map)

    if (studioStyle) {
      hideMapboxLabels(map)
    }

    if (decorated) {
      return
    }

    decorated = true

    rangeTicks(map, layer)

    for (const place of REGIONS) {
      const node = document.createElement('span')
      node.setAttribute('data-region', '')
      node.textContent = place.label
      pin(map, layer, place.lngLat, node)
    }

    for (const place of CITIES) {
      const node = document.createElement('span')
      node.setAttribute('data-city', '')
      if (place.home) {
        node.setAttribute('data-home', '')
      }
      node.textContent = place.label
      pin(map, layer, place.lngLat, node, 'left')
    }
  }

  map.on('load', decorate)
  map.on('style.load', () => {
    if (studioStyle) {
      hideMapboxLabels(map)
    }
  })

  map.on('error', (event) => {
    console.warn('Contact map failed to load', event.error ?? event)
  })

  const resize = new ResizeObserver(() => {
    map.resize()
    if (map.loaded()) {
      fit(map)
    }
  })

  resize.observe(root)
}

function boot() {
  const node = document.querySelector('.contact [data-map]')

  if (node) {
    initContactMap(node)
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot)
} else {
  boot()
}
