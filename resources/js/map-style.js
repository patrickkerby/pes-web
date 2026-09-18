const land = '#9b6252'
const water = '#6e4339'
const line = '#1a120e'

const worldview = [
  'any',
  ['==', ['get', 'worldview'], 'all'],
  ['in', 'US', ['get', 'worldview']],
]

export const contactMapStyle = {
  version: 8,
  name: 'PES Contact',
  sources: {
    composite: {
      type: 'vector',
      url: 'mapbox://mapbox.mapbox-streets-v8',
    },
  },
  glyphs: 'mapbox://fonts/mapbox/{fontstack}/{range}.pbf',
  layers: [
    {
      id: 'background',
      type: 'background',
      paint: { 'background-color': land },
    },
    {
      id: 'water',
      type: 'fill',
      source: 'composite',
      'source-layer': 'water',
      paint: { 'fill-color': water },
    },
    {
      id: 'admin-province',
      type: 'line',
      source: 'composite',
      'source-layer': 'admin',
      filter: [
        'all',
        ['==', ['get', 'admin_level'], 1],
        ['==', ['get', 'iso_3166_1'], 'CA'],
        ['==', ['get', 'maritime'], 'false'],
        worldview,
      ],
      paint: {
        'line-color': line,
        'line-width': 1,
        'line-dasharray': [2.8, 2.2],
        'line-opacity': 0.45,
      },
    },
    {
      id: 'admin-country',
      type: 'line',
      source: 'composite',
      'source-layer': 'admin',
      filter: [
        'all',
        ['==', ['get', 'admin_level'], 0],
        ['==', ['get', 'maritime'], 'false'],
        worldview,
      ],
      paint: {
        'line-color': line,
        'line-width': 1.15,
        'line-opacity': 0.55,
      },
    },
  ],
}
