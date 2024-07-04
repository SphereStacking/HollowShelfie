import { shareOnX } from './platforms/x'
import { shareOnMisskey } from './platforms/misskey'

const shareFunctions = {
  x: shareOnX,
  misskey: shareOnMisskey,
} as const

type SharePlatform = keyof typeof shareFunctions;

export function openShareWindow<T extends SharePlatform>(
  platform: T,
  options: Parameters<typeof shareFunctions[T]>[0]
): void {
  const shareFunction = shareFunctions[platform]
  if (shareFunction) {
    shareFunction(options)
  } else {
    console.error(`Unsupported platform: ${platform}`)
  }
}

export { shareOnX, shareOnMisskey }
