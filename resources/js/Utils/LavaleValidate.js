export const parseErrors = (errors) => {
  const parsedErrors = {}
  for (const [key, value] of Object.entries(errors)) {
    const keys = key.split('.')
    let current = parsedErrors
    while (keys.length > 1) {
      const k = keys.shift()
      if (!current[k]) {
        current[k] = isNaN(keys[0]) ? {} : []
      }
      current = current[k]
    }
    current[keys[0]] = value
  }
  return parsedErrors
}
