export function useAffirmationExercise() { 
  const stepsTitle = {
    1: 'State',
    2: 'Reflect on this Affirmation',
  }

  const stepsDescription = {
    1: 'Your current state influences your perception.',
    2: 'Spending time reflecting on affirmations can make us more aware of the positives in our life.',
  }

  const howTo = {
    1: 'alignment',
    2: 'affirmation',
  }

  return { 
    stepsTitle, 
    stepsDescription,
    howTo
  }
}