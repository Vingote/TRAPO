import { createClient } from 'https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2/+esm';

const SUPABASE_URL = 'https://zgjdgydtvoknniherzqm.supabase.co';
const SUPABASE_KEY = 'sb_publishable_KRAZ9yOKJtm7ZxQSoBbpcg_KX9D59-O';

export const supabase = createClient(SUPABASE_URL, SUPABASE_KEY);