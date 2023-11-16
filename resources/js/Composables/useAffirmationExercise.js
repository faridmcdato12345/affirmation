export function useAffirmationExercise() { 
  const stepsTitle = {
    1: 'Alignment',
    2: 'Own This Affirmation',
  }

  const stepsDescription = {
    1: 'Your alignment affects your perception',
    2: 'You are the source of the change you want to see in your life.',
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